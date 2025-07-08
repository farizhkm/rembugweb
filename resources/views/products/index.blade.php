@extends('layouts.app')

@section('title', 'Produk UMKM')

@section('content')
<section class="pt-10 pb-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Produk UMKM</h1>

            @auth
                <a href="{{ route('products.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                    + Tambah Produk
                </a>
            @endauth
        </div>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-xl shadow mb-8">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="🔍 Cari produk..." class="border-gray-300 rounded-md shadow-sm w-full">

            <select name="category" class="border-gray-300 rounded-md shadow-sm w-full">
                <option value="">Semua Kategori</option>
                <option value="makanan" {{ request('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="kerajinan" {{ request('category') == 'kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                <option value="jasa" {{ request('category') == 'jasa' ? 'selected' : '' }}>Jasa</option>
            </select>

            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md">
                Cari
            </button>
        </form>

        @if ($products->isEmpty())
            <p class="text-center text-gray-500 text-lg">Belum ada produk tersedia saat ini.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white shadow hover:shadow-lg rounded-2xl overflow-hidden transition transform hover:-translate-y-1 duration-200 flex flex-col">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                                Tidak ada gambar
                            </div>
                        @endif

                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-600 line-clamp-2 mb-1">{{ $product->description }}</p>
                            <p class="text-green-600 font-bold text-sm mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            @if ($product->latitude && $product->longitude)
                                <div id="map-{{ $product->id }}" class="w-full h-24 rounded shadow mb-2"></div>
                                <a href="https://www.google.com/maps?q={{ $product->latitude }},{{ $product->longitude }}"
                                   target="_blank"
                                   class="text-blue-500 hover:underline text-xs">
                                    📍 Buka di Google Maps
                                </a>
                            @else
                                <p class="text-xs text-red-500">Lokasi tidak tersedia</p>
                            @endif

                            <div class="flex justify-between items-center mt-auto pt-3">
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="text-sm text-blue-600 hover:underline font-medium">Detail</a>

                                @if ($product->whatsapp_number)
                                    @php
                                        $waMessage = urlencode("Halo, saya tertarik dengan produk *{$product->name}*.");
                                        $waUrl = "https://wa.me/{$product->whatsapp_number}?text={$waMessage}";
                                    @endphp
                                    <a href="{{ $waUrl }}" target="_blank"
                                       class="bg-green-500 text-white text-xs px-3 py-1 rounded hover:bg-green-600 transition">
                                        WA
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($products as $product)
            @if ($product->latitude && $product->longitude)
                const map{{ $product->id }} = L.map('map-{{ $product->id }}', {
                    zoomControl: false,
                    dragging: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    boxZoom: false,
                    touchZoom: false
                }).setView([{{ $product->latitude }}, {{ $product->longitude }}], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map{{ $product->id }});

                L.marker([{{ $product->latitude }}, {{ $product->longitude }}])
                    .addTo(map{{ $product->id }})
                    .bindPopup("{{ $product->name }}");
            @endif
        @endforeach
    });
</script>
@endsection
