@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-6">
            @if ($product->image)
                <div class="h-full">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover rounded-l-xl">
                </div>
            @endif

            <div class="p-6 flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
                    <p class="text-gray-600 mb-4 leading-relaxed">{{ $product->description }}</p>

                    <p class="text-2xl font-semibold text-green-600 mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                @if ($product->whatsapp_number)
                    @php
                        $waMessage = urlencode("Halo, saya tertarik dengan produk *{$product->name}*. Apakah masih tersedia?");
                        $waUrl = "https://wa.me/{$product->whatsapp_number}?text={$waMessage}";
                    @endphp
                    <a href="{{ $waUrl }}" target="_blank"
                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition text-center w-full md:w-auto">
                        📱 Pesan via WhatsApp
                    </a>
                @else
                    <p class="text-sm text-gray-500 italic mt-4">Penjual belum menyediakan nomor WhatsApp.</p>
                @endif
            </div>
        </div>

        @if ($product->latitude && $product->longitude)
            <div class="mt-10">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">📍 Lokasi Produk</h2>
                <div id="map" class="w-full h-64 rounded-xl shadow mb-3"></div>
                <a href="https://www.google.com/maps?q={{ $product->latitude }},{{ $product->longitude }}"
                   target="_blank"
                   class="text-blue-600 hover:underline text-sm inline-block">
                   Lihat di Google Maps →
                </a>
            </div>
        @endif

        @if (auth()->check() && auth()->id() === optional($product->umkm)->user_id)
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('products.edit', $product) }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-lg transition text-center">
                    ✏️ Edit Produk
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition text-center w-full sm:w-auto">
                        🗑️ Hapus Produk
                    </button>
                </form>
            </div>
        @endif

        <div class="mt-12">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">💬 Komentar ({{ $product->comments->count() }})</h2>

            @auth
                <form action="{{ route('comments.store', ['model' => 'products', 'id' => $product->id]) }}" method="POST" class="mb-6">
                    @csrf
                    <textarea name="content" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500" placeholder="Tulis komentar..."></textarea>
                    <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Kirim</button>
                </form>
            @endauth

            @forelse ($product->comments->whereNull('parent_id') as $comment)
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-md shadow-sm mb-3">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold uppercase">
                        {{ substr($comment->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-700">{{ $comment->content }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</p>

                        <div class="flex items-center gap-4 mt-2 text-sm">
                            <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:underline">
                                    👍 Suka ({{ $comment->likes->count() }})
                                </button>
                            </form>

                            <button type="button" class="text-gray-500 hover:underline" onclick="toggleReply({{ $comment->id }})">
                                💬 Balas
                            </button>
                        </div>

                        @auth
                            <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.reply', ['comment' => $comment->id]) }}" method="POST" class="mt-2 hidden">
                                @csrf
                                <textarea name="content" rows="2" class="w-full" placeholder="Tulis balasan..."></textarea>
                                <button type="submit" class="mt-2 bg-green-600 text-white px-4 py-2 rounded text-sm">Kirim Balasan</button>
                            </form>
                        @endauth

                        @foreach ($comment->replies as $reply)
                            <div class="mt-4 ml-4 p-3 bg-white border border-gray-200 rounded-md">
                                <p class="text-sm text-gray-700">{{ $reply->content }}</p>
                                <p class="text-xs text-gray-500 mt-1">→ {{ $reply->user->name }} • {{ $reply->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada komentar.</p>
            @endforelse
        </div>
    </div>
</section>

@if ($product->latitude && $product->longitude)
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const map = L.map('map').setView([{{ $product->latitude }}, {{ $product->longitude }}], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);
                L.marker([{{ $product->latitude }}, {{ $product->longitude }}])
                    .addTo(map)
                    .bindPopup("{{ $product->name }}")
                    .openPopup();
            });

            function toggleReply(id) {
                const form = document.getElementById(`reply-form-${id}`);
                if (form) {
                    form.classList.toggle('hidden');
                }
            }
        </script>
    @endpush
@endif
@endsection
