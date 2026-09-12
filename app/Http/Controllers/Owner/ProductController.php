<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('owner_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('owner.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('owner_id', Auth::id())->get();
        return view('owner.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'owner_id'    => Auth::id(),
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $imagePath,
            'price'       => $request->price,
        ]);

        return redirect()->route('owner.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        if ($product->owner_id !== Auth::id()) abort(403);

        $product->load('category');

        return view('owner.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->owner_id !== Auth::id()) abort(403);

        $categories = Category::where('owner_id', Auth::id())->get();
        return view('owner.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->owner_id !== Auth::id()) abort(403);

        $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image'  => ['nullable', 'boolean'],
        ]);

        $imagePath = $product->image;

        // Hapus foto lama jika diminta
        if ($request->boolean('remove_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $imagePath = null;
        }

        // Upload foto baru
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $imagePath,
            'price'       => $request->price,
        ]);

        return redirect()->route('owner.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        if ($product->owner_id !== Auth::id()) abort(403);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('owner.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function toggleActive(Product $product)
    {
        if ($product->owner_id !== Auth::id()) abort(403);

        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Produk berhasil {$status}!");
    }
}
