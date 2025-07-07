{{-- resources/views/admin/projects/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Proyek')

@section('content')
<h1 class="text-2xl font-bold mb-6">📁 Manajemen Proyek</h1>

@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Judul</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">User</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $project->title }}</td>
                    <td class="px-4 py-3">{{ $project->category }}</td>
                    <td class="px-4 py-3">{{ $project->user->name ?? 'User tidak ditemukan' }}</td>
                    <td class="px-4 py-3">{{ ucfirst($project->status) }}</td>
                    <td class="px-4 py-3">{{ $project->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 space-x-2">
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="text-blue-600 hover:underline text-sm">Detail</a>
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin ingin menghapus proyek ini?')" class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 px-4 py-6">Tidak ada proyek ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
