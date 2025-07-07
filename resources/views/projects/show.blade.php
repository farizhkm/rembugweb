@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md mt-8 space-y-8">

    {{-- Gambar --}}
    @if ($project->image)
        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}"
             class="w-full h-64 object-cover rounded-xl shadow">
    @endif

    {{-- Judul & Info --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $project->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Oleh {{ $project->user->name }} • {{ $project->created_at->diffForHumans() }}</p>
        </div>
        <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
            {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
               ($project->status === 'ongoing' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
            {{ ucfirst($project->status) }}
        </span>
    </div>

    {{-- Detail --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-1">📂 Kategori</h2>
            <p class="text-gray-600">{{ $project->category ?? '-' }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-1">📅 Jadwal</h2>
            <p class="text-gray-600">{{ $project->start_date }} - {{ $project->end_date }}</p>
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-700 mb-1">📝 Deskripsi Proyek</h2>
        <p class="text-gray-700">{{ $project->description }}</p>
    </div>

    {{-- Lokasi --}}
    @if ($project->lat && $project->lng)
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">📍 Lokasi Proyek</h2>
            <div id="map" class="w-full h-64 rounded-xl shadow mb-3"></div>
            <a href="https://www.google.com/maps?q={{ $project->lat }},{{ $project->lng }}" target="_blank"
               class="text-blue-600 hover:underline text-sm">Lihat di Google Maps →</a>
        </div>
    @endif

    {{-- Komentar --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-700 mb-2">💬 Komentar ({{ $project->comments->count() }})</h2>

        {{-- Form komentar utama --}}
        @auth
            <form action="{{ route('comments.store', ['model' => 'projects', 'id' => $project->id]) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="content" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500" placeholder="Tulis komentar..."></textarea>
                <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Kirim</button>
            </form>
        @endauth

        {{-- List komentar --}}
        @forelse ($project->comments->whereNull('parent_id') as $comment)
            <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-md shadow-sm mb-3">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold uppercase">
                    {{ substr($comment->user->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <p class="text-gray-700">{{ $comment->content }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</p>

                    <div class="flex items-center gap-4 mt-2 text-sm">
                        <!-- Like -->
                        <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:underline">
                                👍 Suka ({{ $comment->likes->count() }})
                            </button>
                        </form>

                        <!-- Balas -->
                        <button type="button" class="text-gray-500 hover:underline" onclick="toggleReply({{ $comment->id }})">
                            💬 Balas
                        </button>
                    </div>

                    <!-- Form balasan -->
                    @auth
                    <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.reply', ['comment' => $comment->id]) }}" method="POST" class="mt-2 hidden">
                        @csrf
                        <textarea name="content" rows="2" class="w-full" placeholder="Tulis balasan..."></textarea>
                        <button type="submit" class="mt-2 bg-green-600 text-white px-4 py-2 rounded text-sm">Kirim Balasan</button>
                    </form>
                    @endauth

                    <!-- Balasan -->
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
@endsection

@push('scripts')
@if ($project->lat && $project->lng)
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const map = L.map('map').setView([{{ $project->lat }}, {{ $project->lng }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker([{{ $project->lat }}, {{ $project->lng }}])
            .addTo(map)
            .bindPopup("{{ $project->title }}")
            .openPopup();
    });
    function toggleReply(id) {
        const form = document.getElementById(`reply-form-${id}`);
        if (form) {
            form.classList.toggle('hidden');
        }
    }
</script>
@endif
@endpush
