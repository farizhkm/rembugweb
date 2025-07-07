@extends('layouts.app')

@section('title', $idea->title)

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md mt-8 space-y-8">

    {{-- Gambar --}}
    @if ($idea->image)
        <img src="{{ asset('storage/' . $idea->image) }}" alt="{{ $idea->title }}"
             class="w-full h-64 object-cover rounded-xl shadow">
    @endif

    {{-- Judul & Info --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $idea->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Oleh {{ $idea->user->name }} • {{ $idea->created_at->diffForHumans() }}</p>
        </div>
        <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
            {{ $idea->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
               ($idea->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
            {{ ucfirst($idea->status) }}
        </span>
    </div>

    {{-- Detail --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-1">📂 Kategori</h2>
            <p class="text-gray-600">{{ $idea->category ?? '-' }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-1">👍 Jumlah Vote</h2>
            <p class="text-gray-600"><i class="fa fa-thumbs-up text-blue-500 mr-1"></i> {{ $idea->votes }}</p>
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-700 mb-1">📝 Deskripsi Ide</h2>
        <p class="text-gray-700">{{ $idea->description }}</p>
    </div>

    {{-- Lokasi --}}
    @if ($idea->lat && $idea->lng)
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">📍 Lokasi Ide</h2>
            <div id="map" class="w-full h-64 rounded-xl shadow mb-3"></div>
            <a href="https://www.google.com/maps?q={{ $idea->lat }},{{ $idea->lng }}" target="_blank"
               class="text-blue-600 hover:underline text-sm">Lihat di Google Maps →</a>
        </div>
    @endif

    {{-- Aksi Pemilik --}}
    @if (auth()->id() === $idea->user_id)
        <div class="flex items-center gap-4">
            <a href="{{ route('ideas.edit', $idea) }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-lg transition">
                ✏️ Edit Ide
            </a>
            <form action="{{ route('ideas.destroy', $idea) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus ide ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition">
                    🗑️ Hapus Ide
                </button>
            </form>
        </div>
    @endif

{{-- Komentar --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">💬 Komentar ({{ $idea->comments->count() }})</h2>

    {{-- Form komentar utama --}}
    @auth
        <form action="{{ route('comments.store', ['model' => 'ideas', 'id' => $idea->id]) }}" method="POST" class="mb-6">
            @csrf
            <textarea name="content" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500" placeholder="Tulis komentar..."></textarea>
            <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Kirim</button>
        </form>
    @endauth

    {{-- List komentar --}}
    @forelse ($idea->comments->whereNull('parent_id') as $comment)
        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-md shadow-sm mb-3">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold uppercase">
                {{ substr($comment->user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <p class="text-gray-700">{{ $comment->content }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</p>

                <div class="flex items-center gap-4 mt-2 text-sm">
                    <!-- Tombol Suka -->
                    <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-500 hover:underline">
                            👍 Suka ({{ $comment->likes->count() }})
                        </button>
                    </form>

                    <!-- Tombol Balas -->
                    <button type="button" class="text-gray-500 hover:underline" onclick="toggleReply({{ $comment->id }})">
                        💬 Balas
                    </button>
                </div>

                <!-- Form Balasan (tersembunyi) -->
                @auth
                <form action="{{ route('comments.reply', ['comment' => $comment->id]) }}" method="POST" class="mt-2 hidden" id="reply-form-{{ $comment->id }}">
                    @csrf
                    <textarea name="content" rows="2" class="w-full" placeholder="Tulis balasan..."></textarea>
                    <button type="submit" class="mt-2 bg-green-600 text-white px-4 py-2 rounded">Kirim Balasan</button>
                </form>
                @endauth

                <!-- Tampilkan Balasan -->
                @foreach ($comment->replies as $reply)
                    <div class="mt-4 ml-4 p-3 bg-white border border-gray-200 rounded-md">
                        <p class="text-sm text-gray-700">{{ $reply->content }}</p>
                        <p class="text-xs text-gray-500 mt-1">→ {{ $reply->user->name }} • {{ $reply->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Tombol hapus jika pemilik komentar --}}
            @if (auth()->id() === $comment->user_id)
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus komentar ini?')" class="text-red-500 hover:text-red-700">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            @endif
        </div>
    @empty
        <p class="text-gray-500">Belum ada komentar.</p>
    @endforelse
</div>
@endsection

@push('scripts')
@if ($idea->lat && $idea->lng)
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const map = L.map('map').setView([{{ $idea->lat }}, {{ $idea->lng }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker([{{ $idea->lat }}, {{ $idea->lng }}])
            .addTo(map)
            .bindPopup("{{ $idea->title }}")
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
