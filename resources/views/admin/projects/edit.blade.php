{{-- resources/views/admin/projects/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Proyek')

@section('content')
<h1 class="text-2xl font-bold mb-6">✏️ Edit Proyek</h1>

<form action="{{ route('admin.projects.update', $project->id) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1 font-semibold">Judul</label>
        <input type="text" name="title" value="{{ old('title', $project->title) }}" class="w-full border rounded p-2">
    </div>

    <div>
        <label class="block mb-1 font-semibold">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $project->category) }}" class="w-full border rounded p-2">
    </div>

    <div>
        <label class="block mb-1 font-semibold">Status</label>
        <select name="status" class="w-full border rounded p-2">
            <option value="pending" {{ $project->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ $project->status === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ $project->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </div>

    <div>
        <label class="block mb-1 font-semibold">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $project->description) }}</textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
</form>
@endsection
