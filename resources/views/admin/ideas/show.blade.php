@extends('layouts.admin')

@section('title', 'Detail Ide')

@section('content')
    <h1 class="text-2xl font-bold mb-4">📝 Detail Ide</h1>

    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-2">{{ $idea->title }}</h2>
        <p class="text-sm text-gray-500 mb-2">Kategori: {{ $idea->category }} | Dibuat oleh: {{ $idea->user->name ?? '-' }}</p>
        <p class="text-gray-700 mb-4">{{ $idea->description }}</p>

        @if ($idea->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $idea->image) }}" alt="Gambar Ide" class="max-w-xs rounded">
            </div>
        @endif

        <p class="mb-2">📍 Lokasi: {{ $idea->location }} ({{ $idea->lat }}, {{ $idea->lng }})</p>
        <p class="mb-2">🗳️ Vote: {{ $idea->votes }}</p>
        <p class="mb-2">🕐 Status: 
            <span class="inline-block px-2 py-1 rounded text-sm
                {{ $idea->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                   ($idea->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($idea->status) }}
            </span>
        </p>

        <div class="mt-4">
            <a href="{{ route('admin.ideas.edit', $idea->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                ✏️ Edit Ide
            </a>
        </div>
    </div>

    {{-- Komentar --}}
    <h2 class="text-xl font-semibold mb-4">💬 Komentar</h2>

    @foreach ($idea->comments as $comment)
    <div class="border p-4 rounded mb-3">
        <p class="text-sm text-gray-600"><strong>{{ $comment->user->name }}</strong> mengatakan:</p>
        <p class="text-gray-800">{{ $comment->content }}</p>

        {{-- Tombol Edit --}}
        <button
            onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.toggle('hidden')"
            class="text-blue-500 text-sm mt-2"
        >
            ✏️ Edit
        </button>

        {{-- Form Edit (hidden by default) --}}
        <form id="edit-comment-{{ $comment->id }}" class="hidden mt-2" method="POST" action="{{ route('comments.update', $comment->id) }}">
            @csrf
            @method('PUT')
            <textarea name="content" class="w-full border rounded p-2">{{ $comment->content }}</textarea>
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded mt-1 text-sm">Simpan</button>
        </form>
    </div>
@endforeach

@endsection
