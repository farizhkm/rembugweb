@extends('layouts.admin')

@section('title', 'Edit Ide')

@section('content')
    <h1 class="text-2xl font-bold mb-6">✏️ Edit Ide</h1>

    <form method="POST" action="{{ route('admin.ideas.update', $idea->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Judul</label>
            <input type="text" name="title" value="{{ old('title', $idea->title) }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('description', $idea->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Kategori</label>
            <input type="text" name="category" value="{{ old('category', $idea->category) }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2" required>
                <option value="pending" {{ $idea->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $idea->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ $idea->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
        <a href="{{ route('admin.ideas.index') }}" class="ml-4 text-gray-600 hover:underline">Kembali</a>
    </form>
@endsection
