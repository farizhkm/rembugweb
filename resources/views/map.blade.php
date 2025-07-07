@extends('layouts.app')

@section('title', 'Peta Proyek')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@section('content')
<div class="w-full h-[600px] rounded-md shadow-md" id="map"></div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const projects = @json($projects);
        
        const map = L.map('map').setView([-7.0, 110.4], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        projects.forEach(project => {
            if (project.lat && project.lng) {
                const marker = L.marker([project.lat, project.lng]).addTo(map);
                marker.bindPopup(`<strong>${project.title}</strong><br>
                    <a href="/projects/${project.id}" class="text-blue-500 underline">Lihat Detail</a>`);
            }
        });
    </script>
@endpush
