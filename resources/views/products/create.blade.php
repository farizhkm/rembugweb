@extends('layouts.app')

@section('title', 'Tambah Produk UMKM')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Tambah Produk UMKM</h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-600 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg shadow-sm" required value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block font-medium text-gray-700 mb-1">Harga</label>
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 bg-gray-100 text-gray-700 border border-r-0 border-gray-300 rounded-l-md">
                        Rp
                    </span>
                    <input type="number" name="price" id="price" value="{{ old('price') }}"
                        class="flex-1 block w-full rounded-none rounded-r-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: 10000" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="image" class="block font-medium text-gray-700 mb-1">Gambar Produk</label>
                <input type="file" name="image" id="image" onchange="previewImage(event)"
                    class="w-full border-gray-300 rounded-lg shadow-sm">
                <img id="preview" class="mt-4 w-48 rounded shadow hidden" />
            </div>

            <div class="mb-4">
                <label for="whatsapp_number" class="block font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="tel" name="whatsapp_number" id="whatsapp_number" pattern="62[0-9]{9,13}"
                    placeholder="Contoh: 6281234567890"
                    value="{{ old('whatsapp_number') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm" required>
                <small class="text-gray-500">Gunakan format internasional tanpa + (contoh: 62812...)</small>
            </div>

    <div class="mb-4">
    <label class="block font-medium text-gray-700 mb-1">Lokasi UMKM</label>
    <div id="map" class="w-full h-64 rounded shadow mb-2"></div>
    <p id="lokasi-info" class="text-sm text-gray-600">📍 Mengambil lokasi...</p>

    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
    </div>

            <div class="flex justify-end gap-3">
                <button type="reset" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg transition">
                    Reset
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const img = document.getElementById('preview');
            img.src = reader.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    window.onload = function () {
        if (!navigator.geolocation) {
            document.getElementById("lokasi-info").textContent = "⚠️ Browser tidak mendukung lokasi.";
            return;
        }

        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            const latInput = document.getElementById("latitude");
            const lngInput = document.getElementById("longitude");

            latInput.value = lat;
            lngInput.value = lng;
            document.getElementById("lokasi-info").textContent = "📍 Lokasi berhasil didapatkan. (bisa digeser di peta)";

            const map = L.map('map').setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
            }).addTo(map);

            const marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map).bindPopup("Geser marker untuk ubah lokasi.").openPopup();

            marker.on('dragend', function (e) {
                const newLatLng = marker.getLatLng();
                latInput.value = newLatLng.lat;
                lngInput.value = newLatLng.lng;
            });

        }, function (err) {
            document.getElementById("lokasi-info").textContent = "⚠️ Gagal mendapatkan lokasi: " + err.message;
        });
    };
</script>

@endsection
