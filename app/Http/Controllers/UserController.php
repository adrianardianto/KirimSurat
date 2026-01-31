<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $users = User::latest()->paginate(10);
        return Inertia::render('Users/Index', ['users' => $users]);
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) abort(403);
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATE_USER',
            'description' => "Created user {$user->name}",
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,user'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATE_USER',
            'description' => "Updated user {$user->name}",
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE_USER',
            'description' => "Deleted user {$user->name}",
            'ip_address' => request()->ip()
        ]);

        return back()->with('success', 'User berhasil dihapus.');
    }
}
