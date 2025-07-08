@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
@if (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Proyek</h2>

    <form method="POST" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Proyek</label>
            <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}"
                class="w-full rounded-md @error('title') border-red-500 @enderror">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="5"
                class="w-full rounded-md @error('description') border-red-500 @enderror">{{ old('description', $project->description) }}</textarea>
            @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar Proyek</label>
            <input type="file" name="image" id="image" class="w-full text-gray-700 @error('image') border-red-500 @enderror">
            @if ($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="mt-2 w-32 h-32 object-cover rounded-lg">
            @endif
            @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                    class="w-full rounded-md @error('start_date') border-red-500 @enderror">
                @error('start_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                    class="w-full rounded-md @error('end_date') border-red-500 @enderror">
                @error('end_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full rounded-md @error('status') border-red-500 @enderror">
                <option value="ongoing" {{ old('status', $project->status) === 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ old('status', $project->status) === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Kategori Proyek</label>
            <input type="text" name="category" id="category" value="{{ old('category', $project->category) }}"
                class="w-full rounded-md @error('category') border-red-500 @enderror">
            @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
            <textarea name="address" id="address" rows="2"
                class="w-full rounded-md @error('address') border-red-500 @enderror">{{ old('address', $project->address) }}</textarea>
            @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Alat/Bahan yang Dibutuhkan</label>
            <div id="tools-wrapper">
                @php
                    $tools = old('tools', explode(',', $project->needs ?? ''));
                @endphp
                @foreach ($tools as $tool)
                    <input type="text" name="tools[]" value="{{ $tool }}" class="w-full rounded-md mb-2" placeholder="Contoh: Semen">
                @endforeach
            </div>
            <button type="button" id="add-tool" class="px-3 py-1 bg-gray-200 rounded">+ Tambah Alat/Bahan</button>
            @error('tools') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="lat" class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="text" name="lat" id="lat" value="{{ old('lat', $project->lat) }}"
                    class="w-full rounded-md @error('lat') border-red-500 @enderror" readonly>
            </div>
            <div>
                <label for="lng" class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="text" name="lng" id="lng" value="{{ old('lng', $project->lng) }}"
                    class="w-full rounded-md @error('lng') border-red-500 @enderror" readonly>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Lokasi di Peta</label>
            <button type="button" id="get-location" class="mb-2 bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                Gunakan Lokasi Saya Sekarang
            </button>
            <div id="map" class="h-64 w-full rounded-md shadow-sm"></div>
        </div>

        <div>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-300">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    let map, marker;
    const defaultLat = {{ $project->lat ?? '-7.797068' }};
    const defaultLng = {{ $project->lng ?? '110.370529' }};

    function initMap(lat, lng) {
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
        initMap(defaultLat, defaultLng);

        document.getElementById('get-location').addEventListener('click', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                    marker.setLatLng([lat, lng]);
                    updateLatLngInputs(lat, lng);
                }, () => {
                    alert("Gagal mendapatkan lokasi.");
                });
            } else {
                alert("Browser Anda tidak mendukung Geolocation.");
            }
        });
    });
</script>
<script>
\    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.getElementById('tools-wrapper');
        const button = document.getElementById('add-tool');
        button.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'tools[]';
            input.className = 'w-full rounded-md mb-2';
            input.placeholder = 'Contoh: Cat, Semen, Kuas';
            wrapper.appendChild(input);
        });
    });
</script>

@endpush
