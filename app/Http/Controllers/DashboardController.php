<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // If admin, show global stats. If user, maybe show their stats?
        // Screenshot shows "Administrator", so assuming admin view.
        // Let's allow users to see their own stats if not admin.
        
        $querySurat = Surat::query();
        if (!$user->isAdmin()) {
             $querySurat->where('user_id', $user->id);
        }

        // Optimized aggregation query
        $stats = (clone $querySurat)->toBase()
            ->selectRaw("count(*) as total")
            ->selectRaw("count(case when status = 'approved' then 1 end) as approved")
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->first();

        $totalSurat = $stats->total;
        $approvedSurat = $stats->approved;
        $pendingSurat = $stats->pending;
        
        $totalUser = User::count(); // Admin sees all users count usually.

        $recentSurats = (clone $querySurat)->with(['category', 'user'])->latest()->take(5)->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'total_surat' => $totalSurat,
                'disetujui' => $approvedSurat,
                'pending' => $pendingSurat,
                'total_user' => $totalUser,
            ],
            'recent_surats' => $recentSurats,
        ]);
    }
}
