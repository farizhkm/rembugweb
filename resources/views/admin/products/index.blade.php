@extends('layouts.admin')

@section('title', 'Manajemen Produk UMKM')

@section('content')
    <h1 class="text-2xl font-bold mb-6">💼 Manajemen Produk UMKM</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">No. WA</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $product->name }}</td>
                        <td class="px-4 py-3">{{ Str::limit($product->description, 50) }}</td>
                        <td class="px-4 py-3">Rp{{ number_format($product->price) }}</td>
                        <td class="px-4 py-3">{{ $product->whatsapp_number }}</td>
                        <td class="px-4 py-3">{{ $product->user->name ?? 'User tidak ditemukan' }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-600 hover:underline text-sm">Detail</a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus produk ini?')" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 px-4 py-6">Tidak ada produk ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
