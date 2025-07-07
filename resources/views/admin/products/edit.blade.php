@extends('layouts.admin')

@section('title', 'Edit Produk UMKM')

@section('content')
    <h1 class="text-2xl font-bold mb-6">✏️ Edit Produk UMKM</h1>

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border rounded px-3 py-2" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Harga</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nomor WhatsApp</label>
            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $product->whatsapp_number) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Gambar Produk (opsional)</label>
            <input type="file" name="image" class="w-full border rounded px-3 py-2">
            @if ($product->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-32 rounded shadow">
                </div>
            @endif
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
        <a href="{{ route('admin.products.index') }}" class="ml-4 text-gray-600 hover:underline">Kembali</a>
    </form>
@endsection