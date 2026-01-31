<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('surats')->get()->map(function($cat) {
            $cat->count = $cat->surats_count;
            return $cat;
        });
        return Inertia::render('Categories/Index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:categories,code',
            'format_code' => 'required|string|max:10',
            'description' => 'nullable|string'
        ]);

        Category::create($request->all());
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATE_TYPE',
            'description' => "Created surat type {$request->name}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Tipe surat berhasil ditambahkan.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Tipe surat dihapus.');
    }
}
