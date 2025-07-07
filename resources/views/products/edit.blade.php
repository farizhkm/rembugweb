@extends('layouts.app')

@section('title', 'Edit Produk UMKM')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Edit Produk UMKM</h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-600 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg shadow-sm"
                    value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" name="price" id="price" class="w-full border-gray-300 rounded-lg shadow-sm"
                    value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block font-medium text-gray-700 mb-1">Ganti Gambar (opsional)</label>
                <input type="file" name="image" id="image" class="w-full border-gray-300 rounded-lg shadow-sm">
                @if ($product->image)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Gambar Saat Ini:</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-auto mt-1 rounded-md border">
                    </div>
                @endif
            </div>

            <div class="mb-6">
                <label for="whatsapp_number" class="block font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number"
                    value="{{ old('whatsapp_number', $product->whatsapp_number) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>

            {{-- Lokasi Interaktif --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Lokasi UMKM</label>
                <div id="map" class="w-full h-64 rounded shadow mb-2"></div>
                <p id="lokasi-info" class="text-sm text-gray-600">📍 Geser marker untuk ubah lokasi.</p>

                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $product->latitude) }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $product->longitude) }}">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('products.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Peta --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const lat = parseFloat(document.getElementById("latitude").value) || -6.2;
            const lng = parseFloat(document.getElementById("longitude").value) || 106.8;

            const map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map).bindPopup("Geser marker untuk mengubah lokasi.").openPopup();

            marker.on('dragend', function () {
                const pos = marker.getLatLng();
                document.getElementById("latitude").value = pos.lat;
                document.getElementById("longitude").value = pos.lng;
            });
        });
    </script>
@endpush
@endsection
