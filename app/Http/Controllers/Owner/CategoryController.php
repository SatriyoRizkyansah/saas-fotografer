<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('owner_id', Auth::id())->latest()->paginate(10);
        return view('owner.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('owner.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'owner_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return redirect()->route('owner.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        if ($category->owner_id !== Auth::id()) {
            abort(403);
        }

        return view('owner.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->owner_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('owner.categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Category $category)
    {
        if ($category->owner_id !== Auth::id()) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('owner.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
