@extends('layouts.app')

@section('title', 'Tambah Proyek')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Proyek Baru</h2>

    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Judul -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Proyek</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full rounded-md @error('title') border-red-500 @enderror">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="5" class="w-full rounded-md @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Gambar -->
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" name="image" id="image" class="w-full text-gray-700 @error('image') border-red-500 @enderror">
            @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Preview Gambar -->
        <div id="image-preview" class="mb-4 hidden">
            <img src="#" alt="Preview Gambar" class="h-40 rounded shadow">
        </div>

        <!-- Tanggal -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full rounded-md @error('start_date') border-red-500 @enderror">
                @error('start_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full rounded-md @error('end_date') border-red-500 @enderror">
                @error('end_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full rounded-md @error('status') border-red-500 @enderror">
                <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Kategori -->
        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Kategori Proyek</label>
            <input type="text" name="category" id="category" value="{{ old('category') }}" class="w-full rounded-md @error('category') border-red-500 @enderror" placeholder="Contoh: Taman, Jalan, dll">
            @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Alamat Lengkap -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
            <textarea name="address" id="address" rows="2" class="w-full rounded-md @error('address') border-red-500 @enderror" placeholder="Contoh: Jl. Merpati No. 2, RT 03 RW 05, Kelurahan ABC...">{{ old('address') }}</textarea>
            @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Alat/Bahan -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Alat/Bahan yang Dibutuhkan</label>
            <div id="tools-wrapper">
                <input type="text" name="tools[]" class="w-full rounded-md mb-2" placeholder="Contoh: Cat">
            </div>
            <button type="button" id="add-tool" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+ Tambah Alat/Bahan</button>
        </div>

        <!-- Latitude & Longitude -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="lat" class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="text" name="lat" id="lat" value="{{ old('lat') }}" class="w-full rounded-md @error('lat') border-red-500 @enderror" readonly>
                @error('lat') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="lng" class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="text" name="lng" id="lng" value="{{ old('lng') }}" class="w-full rounded-md @error('lng') border-red-500 @enderror" readonly>
                @error('lng') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Peta Lokasi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Lokasi di Peta</label>
            <button type="button" id="get-location" class="mb-2 bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                Gunakan Lokasi Saya Sekarang
            </button>
            <div id="map" class="h-64 w-full rounded-md shadow-sm"></div>
        </div>

        <!-- Tombol -->
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">Simpan Proyek</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    let map, marker;
    const defaultLat = -7.797068;
    const defaultLng = 110.370529;

    function initMap(lat = defaultLat, lng = defaultLng) {
        map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        updateLatLngInputs(lat, lng);

        marker.on('dragend', function () {
            const { lat, lng } = marker.getLatLng();
            updateLatLngInputs(lat, lng);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            updateLatLngInputs(e.latlng.lat, e.latlng.lng);
        });
    }

    function updateLatLngInputs(lat, lng) {
        document.getElementById('lat').value = lat.toFixed(6);
        document.getElementById('lng').value = lng.toFixed(6);
    }

    document.addEventListener("DOMContentLoaded", () => {
        initMap();

        document.getElementById('get-location').addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 15);
                        marker.setLatLng([lat, lng]);
                        updateLatLngInputs(lat, lng);
                    },
                    function () {
                        alert("Gagal mendapatkan lokasi. Izinkan akses lokasi di browser Anda.");
                    }
                );
            } else {
                alert("Browser Anda tidak mendukung Geolocation.");
            }
        });

        // Tambah input alat/bahan
        document.getElementById('add-tool').addEventListener('click', function () {
            const wrapper = document.getElementById('tools-wrapper');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'tools[]';
            input.className = 'w-full rounded-md mb-2';
            input.placeholder = 'Contoh: Kayu, Semen, dll';
            wrapper.appendChild(input);
        });

        // Preview Gambar
        document.getElementById('image').addEventListener('change', function (e) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            const file = e.target.files[0];
            if (file) {
                img.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    });
</script>
@endpush
