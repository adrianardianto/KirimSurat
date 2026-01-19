<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        // Only admin can access this is handled by route/middleware or check here
        $logs = AuditLog::with('user')->latest()->paginate(20);
        return view('audit.index', compact('logs'));
    }
}
