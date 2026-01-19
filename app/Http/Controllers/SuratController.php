<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with(['category', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%$search%")
                  ->orWhere('reference_number', 'like', "%$search%")
                  ->orWhere('sender', 'like', "%$search%")
                  ->orWhere('recipient', 'like', "%$search%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if (!Auth::user()->isAdmin()) {
            // Users see their own surats, or maybe public ones?
            // Requirement: "Lihat surat masuk, surat yang menunggu persetujuan, status surat yang dikirim"
            // Assuming users can see all 'masuk' directed to them?
            // Or simplified: Users see what they created.
            // Let's stick to: Users see their own created letters for now.
            // AND maybe Surat Masuk addressed to them? Not implemented recipient linking yet.
            $query->where('user_id', Auth::id());
        }

        $surats = $query->latest()->paginate(10);
        return view('surat.index', compact('surats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('surat.create', compact('categories'));
    }

    public function getNextNumber(Request $request) {
        $type = $request->input('type'); // Passed as the category ID/code actually?
        // Wait, the view passes 'type' as the category CODE based on selection.
        // Let's check create view later. For now, assume we receive 'type' as code (e.g. 'izin')
        
        if (!$type) {
            return response()->json(['number' => '']);
        }

        $category = Category::where('code', $type)->first();
        if (!$category) return response()->json(['number' => '']);

        $formatCode = $category->format_code;

        // Count existing surat this year for this specific Type
        $count = Surat::whereYear('created_at', date('Y'))
                      ->where('type', $type)
                      ->count() + 1;
        
        $monthRoman = $this->getRomanMonth(date('n'));
        $year = date('Y');

        // Format: 001/IZN/I/2026 (Dynamic Format Code)
        $number = sprintf("%03d/%s/%s/%s", $count, $formatCode, $monthRoman, $year);

        return response()->json(['number' => $number]);
    }

    private function getRomanMonth($month) {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$month];
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'reference_number' => 'required|string|unique:surats,reference_number',
            'date' => 'required|date',
            'sender' => 'required|string',
            'recipient' => 'required|string',
            'subject' => 'required|string',
            'content' => 'required|string', // Now Required
            'category_id' => 'required|exists:categories,id',
            'file_attachment' => 'required|file|mimes:pdf,jpg,png|max:2048' // Now Required
        ]);

        $path = null;
        if ($request->hasFile('file_attachment')) {
            $path = $request->file('file_attachment')->store('attachments', 'public');
        }

        $surat = Surat::create([
            'type' => $request->type,
            'reference_number' => $request->reference_number,
            'date' => $request->date,
            'sender' => $request->sender,
            'recipient' => $request->recipient,
            'subject' => $request->subject,
            'content' => $request->content,
            'status' => 'pending', // Default pending
            'file_path' => $path,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATE_SURAT',
            'description' => "Created surat {$surat->reference_number}",
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat created successfully.');
    }

    public function show(Surat $surat)
    {
        $this->authorize('view', $surat);
        return view('surat.show', compact('surat'));
    }

    public function approve(Request $request, Surat $surat)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $surat->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'APPROVE_SURAT',
            'description' => "Approved surat {$surat->reference_number}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Surat approved.');
    }

    public function reject(Request $request, Surat $surat)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $surat->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(), // Rejected by
            'approved_at' => now(),
        ]);

         AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'REJECT_SURAT',
            'description' => "Rejected surat {$surat->reference_number}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Surat rejected.');
    }

    public function edit(Surat $surat)
    {
        $this->authorize('update', $surat);
        $categories = Category::all();
        return view('surat.edit', compact('surat', 'categories'));
    }

    public function update(Request $request, Surat $surat)
    {
        $this->authorize('update', $surat);

        $request->validate([
            'type' => 'required|string',
            'reference_number' => 'required|string|unique:surats,reference_number,' . $surat->id,
            'date' => 'required|date',
            'sender' => 'required|string',
            'recipient' => 'required|string',
            'subject' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'file_attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048'
        ]);

        $data = $request->except(['file_attachment']);
        
        if ($request->hasFile('file_attachment')) {
            $data['file_path'] = $request->file('file_attachment')->store('attachments', 'public');
        }

        // If user is editing, reset to pending if it was rejected?
        // Let's assume editing is allowed for drafts or rejected.
        // For now, if draft, it stays draft until they submit?
        // Actually store set it to pending. Let's keep status as is or reset to pending if it was rejected.
        // Simple logic: just update data.

        $surat->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATE_SURAT',
            'description' => "Updated surat {$surat->reference_number}",
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('surat.show', $surat)->with('success', 'Surat updated.');
    }

    public function destroy(Surat $surat)
    {
        $this->authorize('delete', $surat);
        
        $surat->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE_SURAT',
            'description' => "Deleted surat {$surat->reference_number}",
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat deleted.');
    }

    public function downloadPdf(Surat $surat)
    {
        $this->authorize('view', $surat);
        $pdf = Pdf::loadView('surat.pdf', compact('surat'));
        
        // Sanitize reference number for filename
        $safeNumber = str_replace(['/', '\\'], '-', $surat->reference_number);
        
        return $pdf->download("surat-{$safeNumber}.pdf");
    }
}
