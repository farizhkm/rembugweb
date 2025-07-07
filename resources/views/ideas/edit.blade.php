@extends('layouts.app')

@section('title', 'Edit Ide')

@section('content')

    @if (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md mt-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Ide</h2>
        <form method="POST" action="{{ route('ideas.update', $idea) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Judul Ide -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Ide</label>
                <input type="text" name="title" id="title" value="{{ old('title', $idea->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="category" id="category" value="{{ old('category', $idea->category) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror">
                @error('category')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                    <option value="pending" {{ old('status', $idea->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $idea->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ old('status', $idea->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $idea->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Lokasi Otomatis -->
            <div class="mb-4">
                <button type="button" id="use-location" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">📍 Sesuaikan Lokasi Otomatis</button>
            </div>

            <!-- Peta -->
            <div id="map" class="w-full h-64 mb-4 rounded-lg shadow"></div>

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label for="lat" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" name="lat" id="lat" value="{{ old('lat', $idea->lat) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="lng" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" name="lng" id="lng" value="{{ old('lng', $idea->lng) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <!-- Gambar -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Ide</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full text-gray-700 @error('image') border-red-500 @enderror">
                @if ($idea->image)
                    <img src="{{ asset('storage/' . $idea->image) }}" alt="{{ $idea->title }}" class="mt-2 w-32 h-32 object-cover rounded-lg">
                @endif
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map;
        let marker;
        let initialLat = "{{ old('lat', $idea->lat) }}";
        let initialLng = "{{ old('lng', $idea->lng) }}";

        function initMap(lat, lng) {
            map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function () {
                const newLatLng = marker.getLatLng();
                document.getElementById('lat').value = newLatLng.lat;
                document.getElementById('lng').value = newLatLng.lng;
            });
        }

        if (initialLat && initialLng) {
            initMap(initialLat, initialLng);
        }

        document.getElementById('use-location').addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    if (!map) {
                        initMap(lat, lng);
                    } else {
                        map.setView([lat, lng], 13);
                        marker.setLatLng([lat, lng]);
                    }
                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                }, function (err) {
                    alert("Gagal mendapatkan lokasi: " + err.message);
                });
            } else {
                alert("Browser tidak mendukung geolocation");
            }
        });
    </script>
@endsection
