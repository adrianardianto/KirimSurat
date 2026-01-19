<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $stats = [
                'surat_masuk' => Surat::where('type', 'masuk')->count(),
                'surat_keluar' => Surat::where('type', 'keluar')->count(),
                'pending' => Surat::where('status', 'pending')->count(),
                'users' => User::count(),
            ];
            $recent_logs = AuditLog::with('user')->latest()->take(5)->get();
            $recent_surats = Surat::with('user')->latest()->take(5)->get();
        } else {
            $stats = [
                'surat_masuk' => Surat::where('type', 'masuk')->where('user_id', $user->id)->count(),
                'surat_keluar' => Surat::where('type', 'keluar')->where('user_id', $user->id)->count(),
                'pending' => Surat::where('status', 'pending')->where('user_id', $user->id)->count(),
            ];
            $recent_logs = AuditLog::where('user_id', $user->id)->latest()->take(5)->get();
            $recent_surats = Surat::where('user_id', $user->id)->latest()->take(5)->get();
        }

        return view('dashboard', compact('stats', 'recent_logs', 'recent_surats'));
    }
}
