@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
    <h1 class="text-2xl font-bold mb-6">🛍️ Detail Produk UMKM</h1>

    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
        <p class="mb-2 text-gray-700">{{ $product->description }}</p>
        <p class="mb-2 text-green-700 font-semibold">Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
        <p class="mb-2">WA: 
            <a href="https://wa.me/{{ $product->whatsapp_number }}" 
               class="text-blue-600" 
               target="_blank">{{ $product->whatsapp_number }}
            </a>
        </p>
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-64 mt-4 rounded">
        @endif
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">💬 Komentar</h3>
        @foreach ($product->comments as $comment)
            <div class="border-b py-2">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <strong>{{ $comment->user->name }}</strong>
                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        <p class="mt-1">{{ $comment->content }}</p>
                    </div>
                    <form action="{{ route('admin.products.comments.update', $comment->id) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')
                        <input type="text" name="content" value="{{ $comment->content }}" class="border px-2 py-1 rounded text-sm w-48">
                        <button class="bg-yellow-500 text-white text-sm px-2 py-1 rounded">Edit</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
