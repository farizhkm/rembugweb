@extends('layouts.app')

@section('title', 'Peta Kolaborasi')

@section('content')
    <div class="mb-4">
        <h1 class="text-3xl font-bold text-gray-800">🌍 Peta Kolaborasi Masyarakat</h1>
        <p class="text-gray-500">Temukan ide, proyek, dan produk UMKM yang ada di sekitarmu!</p>
    </div>

    {{-- Filter & Tools --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
        <div class="space-x-4 text-sm">
            <label><input type="checkbox" id="filter-ideas" checked> Tampilkan Ide</label>
            <label><input type="checkbox" id="filter-umkm" checked> Tampilkan UMKM</label>
            <label><input type="checkbox" id="filter-projects" checked> Tampilkan Proyek</label>
        </div>
        <div class="flex gap-2">
            <input type="text" id="searchInput" placeholder="Cari lokasi..." class="rounded-md border-gray-300 shadow-sm focus:ring focus:ring-blue-200 px-3 py-1 w-60 text-sm">
            <button id="btn-locate" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                🎯 Gunakan Lokasi Saya
            </button>
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 text-blue-800 p-4 rounded shadow">
            <h3 class="text-sm font-semibold">Jumlah Ide</h3>
            <p class="text-2xl font-bold">{{ $ideaCount }}</p>
        </div>
        <div class="bg-green-100 text-green-800 p-4 rounded shadow">
            <h3 class="text-sm font-semibold">Jumlah Proyek</h3>
            <p class="text-2xl font-bold">{{ $projectCount }}</p>
        </div>
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded shadow">
            <h3 class="text-sm font-semibold">Jumlah UMKM</h3>
            <p class="text-2xl font-bold">{{ $umkmCount }}</p>
        </div>
    </div>

    {{-- Peta --}}

    <div id="map" class="z-0 h-[550px] w-full rounded-lg shadow"></div>


   {{-- Legend Marker --}}
<div class="bg-gray-50 border border-gray-200 rounded-lg p-6 max-w-3xl mx-auto mt-10 shadow-sm">
    <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
        🧭 Keterangan Ikon:
    </h3>
    <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
        <div class="flex items-center gap-2">
            <img src="/icons/marker-icon.png" class="w-5 h-5" alt="Ide"> Ide Kolaborasi
        </div>
        <div class="flex items-center gap-2">
            <img src="/icons/shop.png" class="w-5 h-5" alt="UMKM"> Produk UMKM
        </div>
        <div class="flex items-center gap-2">
            <img src="/icons/project.png" class="w-5 h-5" alt="Proyek"> Proyek Warga
        </div>
    </div>
</div>

{{-- Ajakan Kontribusi --}}
<div class="bg-gradient-to-r from-blue-50 to-green-50 mt-12 py-10 rounded-lg shadow-inner text-center px-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-3">🤝 Ingin Berkontribusi?</h2>
    <p class="text-gray-600 mb-6 text-sm sm:text-base">
        Ayo tambahkan ide, proyek, atau produk UMKM dari wilayahmu dan ikut membangun lingkungan sekitar secara kolaboratif!
    </p>
    <div class="flex justify-center gap-4 flex-wrap">
        <a href="{{ route('ideas.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow text-sm sm:text-base transition">
            💡 Tambah Ide
        </a>
        <a href="{{ route('projects.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg shadow text-sm sm:text-base transition">
            🛠️ Buat Proyek
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ideas = @json($ideas);
    const umkms = @json($umkms);
    const projects = @json($projects);

    const map = L.map('map').setView([-7.5, 110], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(map);

    const ideaMarkers = [], umkmMarkers = [], projectMarkers = [];

    // Marker Ide
    ideas.forEach(idea => {
        const popup = `
            <div class="max-w-xs">
                <h3 class="font-semibold text-blue-600 mb-1">💡 ${idea.title}</h3>
                <p class="text-sm text-gray-700 mb-2">${idea.description?.slice(0, 100)}...</p>
                <a href="/ideas/${idea.id}" class="text-blue-500 underline text-sm">Lihat Detail</a>
            </div>
        `;
        const marker = L.marker([idea.lat, idea.lng])
            .bindPopup(popup);
        ideaMarkers.push(marker);
        marker.addTo(map);
    });

    // Marker UMKM
    umkms.forEach(umkm => {
        const popup = `
            <div class="max-w-xs">
                <h3 class="font-semibold text-green-600 mb-1">🏪 ${umkm.name}</h3>
                <p class="text-sm text-gray-700 mb-2">${umkm.description?.slice(0, 100)}...</p>
                <a href="/products/${umkm.id}" class="text-green-600 underline text-sm">Lihat Produk</a>
            </div>
        `;
        const marker = L.marker([umkm.lat, umkm.lng], {
            icon: L.icon({
                iconUrl: '/icons/shop.png',
                iconSize: [25, 25],
                iconAnchor: [12, 25]
            })
        }).bindPopup(popup);
        umkmMarkers.push(marker);
        marker.addTo(map);
    });

    // Marker Proyek
    projects.forEach(project => {
        const popup = `
            <div class="max-w-xs">
                <h3 class="font-semibold text-indigo-600 mb-1">🛠️ ${project.title}</h3>
                <img src="/storage/${project.image ?? 'default.jpg'}" class="w-full h-24 object-cover mb-2 rounded">
                <p class="text-sm text-gray-700 mb-2">${project.description?.slice(0, 100)}...</p>
                <a href="/projects/${project.id}" class="text-indigo-600 underline text-sm">Lihat Detail</a>
            </div>
        `;
        const marker = L.marker([project.lat, project.lng], {
            icon: L.icon({
                iconUrl: '/icons/project.png',
                iconSize: [25, 25],
                iconAnchor: [12, 25]
            })
        }).bindPopup(popup);
        projectMarkers.push(marker);
        marker.addTo(map);
    });

    // Filter checkbox
    document.getElementById('filter-ideas').addEventListener('change', function () {
        ideaMarkers.forEach(m => this.checked ? m.addTo(map) : map.removeLayer(m));
    });
    document.getElementById('filter-umkm').addEventListener('change', function () {
        umkmMarkers.forEach(m => this.checked ? m.addTo(map) : map.removeLayer(m));
    });
    document.getElementById('filter-projects').addEventListener('change', function () {
        projectMarkers.forEach(m => this.checked ? m.addTo(map) : map.removeLayer(m));
    });

    // Gunakan Lokasi Saya
    document.getElementById('btn-locate').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                const { latitude, longitude } = pos.coords;
                map.setView([latitude, longitude], 14);
                L.circle([latitude, longitude], {
                    radius: 200,
                    color: 'blue',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.3
                }).addTo(map).bindPopup("📍 Lokasi Anda").openPopup();
            }, () => {
                alert("Tidak dapat mengakses lokasi.");
            });
        } else {
            alert("Browser tidak mendukung geolokasi.");
        }
    });

    // Pencarian lokasi
    document.getElementById('searchInput').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const query = this.value;
            if (!query) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(locations => {
                    if (locations.length > 0) {
                        const loc = locations[0];
                        map.setView([loc.lat, loc.lon], 14);
                        L.marker([loc.lat, loc.lon]).addTo(map)
                            .bindPopup(`📍 ${loc.display_name}`).openPopup();
                    } else {
                        alert("Lokasi tidak ditemukan.");
                    }
                });
        }
    });
</script>
@endpush
