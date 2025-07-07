@extends('layouts.admin')

@section('title', 'Detail Proyek')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">📁 Detail Proyek</h1>

    {{-- Info proyek --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <div class="mb-4">
            @if ($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="Gambar Proyek" class="w-full max-h-60 object-cover rounded mb-4">
            @endif

            <h2 class="text-xl font-semibold">{{ $project->title }}</h2>
            <p class="text-gray-600">Kategori: <strong>{{ $project->category }}</strong></p>
            <p class="text-gray-600">Status: <span class="text-sm px-2 py-1 rounded 
                {{ $project->status == 'Ongoing' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                {{ $project->status }}</span></p>
            <p class="text-gray-600">Alamat: {{ $project->address }}</p>
            <p class="text-gray-600 mt-2">📝 {{ $project->description }}</p>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                ✏️ Edit projects
            </a>
        </div>
    </div>

    {{-- Komentar --}}
    <div class="bg-white rounded shadow p-6">
        <h3 class="text-lg font-semibold mb-4">💬 Komentar</h3>

        @foreach ($project->comments as $comment)
            <div class="mb-4 border-b pb-4">
                <p class="font-semibold text-sm text-gray-700">{{ $comment->user->name }} - 
                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </p>
                <form action="{{ route('admin.projects.comments.update', $comment->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PUT')
                    <textarea name="content" class="w-full border rounded p-2 text-sm">{{ $comment->content }}</textarea>
                    <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">
                        Simpan
                    </button>
                </form>
            </div>
        @endforeach

        @if ($project->comments->isEmpty())
            <p class="text-gray-500 text-sm">Belum ada komentar.</p>
        @endif
    </div>
</div>
@endsection
