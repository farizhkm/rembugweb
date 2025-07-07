<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::with(['user', 'umkm'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['comments.user', 'user', 'umkm'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'whatsapp_number' => 'required|string',
        'status' => 'required|in:active,inactive',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload image jika ada
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('product_images', 'public');
        $validated['image'] = $imagePath;
    }

    $product->update($validated);

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
}

    public function updateComment(Request $request, Comment $comment)
    {
        $user = auth()->user();

        if ($user->id !== $comment->user_id && $user->role !== 'admin') {
            return redirect()->back()->with('error', 'Tidak diizinkan mengedit komentar ini.');
        }

        $request->validate(['content' => 'required|string']);

        $comment->update(['content' => $request->content]);

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
