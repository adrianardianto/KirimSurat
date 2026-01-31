<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Exports\SuratExport;
use Maatwebsite\Excel\Facades\Excel;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with(['category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%$search%")
                  ->orWhere('reference_number', 'like', "%$search%")
                  ->orWhere('sender', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%")
                  ->orWhere('recipient', 'like', "%$search%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
             $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $surats = $query->latest()->paginate(10)->withQueryString();
        
        return Inertia::render('Surat/Index', [
            'surats' => $surats,
            'filters' => $request->only(['search', 'type', 'status', 'start_date', 'end_date']),
        ]);
    }

    public function create()
    {
        $categories = \Illuminate\Support\Facades\Cache::remember('categories', 60, function () {
            return Category::all();
        });
        return Inertia::render('Surat/Create', compact('categories'));
    }

    public function getNextNumber(Request $request) {
        $type = $request->input('type'); // Category Code
        
        if (!$type) {
            return response()->json(['number' => '']); // Or error
        }

        $category = Category::where('id', $type)->first(); // Typo in logic previously? Request sends ID usually.
        // Wait, typical select sends ID. Let's assume ID.
        if(!$category) {
             // Fallback if type was actually the code or we need to find by code?
             // If frontend sends ID, we use ID.
             // If frontend sends Code, we use Code.
             // Let's try to find by ID first, then Code.
             $category = Category::where('code', $type)->orWhere('id', $type)->first();
        }
        
        if (!$category) return response()->json(['number' => '']);

        $formatCode = $category->format_code;

        // Count existing surat this year for this specific Type (Category)
        $count = Surat::whereYear('date', date('Y'))
                      ->where('category_id', $category->id)
                      ->count() + 1;
        
        $monthRoman = $this->getRomanMonth(date('n'));
        $year = date('Y');

        // Format: 001/IZN/I/2026
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
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'file_attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('file_attachment')) {
            $uploadedPath = $request->file('file_attachment')->store('attachments', 'public');
            if ($uploadedPath) {
                $path = $uploadedPath;
            }
        }

        $surat = Surat::create([
            'type' => $request->type,
            'reference_number' => $request->reference_number,
            'date' => $request->date,
            'sender' => $request->sender,
            'recipient' => $request->recipient,
            'subject' => $request->subject,
            'content' => $request->content,
            'status' => 'pending',
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
        $surat->load(['category', 'user']);
        return Inertia::render('Surat/Show', compact('surat'));
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

        return redirect()->route('surat.show', $surat)->with('success', 'Surat approved.');
    }

    public function reject(Request $request, Surat $surat)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $surat->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

         AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'REJECT_SURAT',
            'description' => "Rejected surat {$surat->reference_number}. Reason: {$request->rejection_reason}",
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('surat.show', $surat)->with('success', 'Surat rejected.');
    }

    public function edit(Surat $surat)
    {
        $this->authorize('update', $surat);
        $categories = Category::all();
        return Inertia::render('Surat/Edit', compact('surat', 'categories'));
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
            $uploadedPath = $request->file('file_attachment')->store('attachments', 'public');
            if ($uploadedPath) {
                $data['file_path'] = $uploadedPath;
            }
        }

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
        
        $base64Qr = null;
        if ($surat->status === 'approved') {
            $url = \Illuminate\Support\Facades\URL::signedRoute('surat.verify', ['surat' => $surat->id]);
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate($url);
            $base64Qr = 'data:image/svg+xml;base64,' . base64_encode($qrCode);
        }

        $pdf = Pdf::loadView('surat.pdf', compact('surat', 'base64Qr'));
        
        $safeNumber = str_replace(['/', '\\'], '-', $surat->reference_number);
        
        return $pdf->download("surat-{$safeNumber}.pdf");
    }

    public function verify(Request $request, Surat $surat)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        return view('surat.verify', compact('surat'));
    }

    public function export(Request $request)
    {
        return Excel::download(new SuratExport($request->all()), 'laporan-surat.xlsx');
    }

    public function print(Request $request)
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

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        
        $surats = $query->latest()->get();

        $pdf = Pdf::loadView('reports.surat_pdf', compact('surats'));
        return $pdf->stream('laporan-surat.pdf');
    }
}
