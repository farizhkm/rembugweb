<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->with('umkm')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $umkms = UMKM::all();
        return view('products.create', compact('umkms'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name'             => 'required|string|max:255',
        'description'      => 'nullable|string',
        'price'            => 'required|numeric',
        'image'            => 'nullable|image|max:2048',
        'whatsapp_number'  => 'required|string|max:20',
        'latitude'         => 'required|numeric',
        'longitude'        => 'required|numeric',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    $user = auth()->user();

    // Pastikan user punya UMKM
    $umkm = $user->umkm ?? $user->umkm()->create([]);

    // Simpan produk
    $product = Product::create([
        'umkm_id'         => $umkm->id,
        'name'            => $request->name,
        'description'     => $request->description,
        'price'           => $request->price,
        'image'           => $imagePath,
        'whatsapp_number' => $request->whatsapp_number,
        'latitude'        => $request->latitude,
        'longitude'       => $request->longitude,
    ]);

    // Simpan riwayat aktivitas
    \App\Models\Activity::create([
        'user_id'      => $user->id,
        'action'       => 'created_product',
        'subject_type' => \App\Models\Product::class,
        'subject_id'   => $product->id,
        'description'  => 'Menambahkan produk UMKM: ' . $product->name,
    ]);
    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
}
    public function destroy(Product $product)
{
    // Pastikan user yang login adalah pemilik produk
    if (auth()->id() !== $product->umkm->user_id) {
        return redirect()->route('products.index')->with('error', 'Anda tidak diizinkan menghapus produk ini.');
    }

    if ($product->image && Storage::exists('public/' . $product->image)) {
        Storage::delete('public/' . $product->image);
    }

    $product->delete();

    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
}

    public function show(Product $product)
{
    $product->load(['comments.user', 'comments.replies.user']);
    return view('products.show', compact('product'));
}
    public function edit(Product $product)
{
    if (auth()->id() !== $product->umkm->user_id) {
        return redirect()->route('products.index')->with('error', 'Anda tidak diizinkan mengedit produk ini.');
    }

    return view('products.edit', compact('product'));
}

public function update(Request $request, Product $product)
{
    if (auth()->id() !== $product->umkm->user_id) {
        return redirect()->route('products.index')->with('error', 'Anda tidak diizinkan mengupdate produk ini.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
        'whatsapp_number' => 'required|string|max:20',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    if ($request->hasFile('image')) {
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }
        $product->image = $request->file('image')->store('products', 'public');
    }

    $product->update($request->except('image'));

    return redirect()->route('products.show', $product)->with('success', 'Produk berhasil diperbarui.');
}

}
