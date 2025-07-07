@extends('layouts.admin')

@section('title', 'Manajemen Ide')

@section('content')
    <h1 class="text-2xl font-bold mb-6">🧠 Manajemen Ide</h1>

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
                    <th class="px-4 py-3">Vote</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ideas as $idea)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $idea->title }}</td>
                        <td class="px-4 py-3">{{ $idea->category }}</td>
                        <td class="px-4 py-3">{{ $idea->user->name ?? 'User tidak ditemukan' }}</td>
                        <td class="px-4 py-3">{{ $idea->votes }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-sm rounded 
                                {{ $idea->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 
                                   ($idea->status == 'approved' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                {{ ucfirst($idea->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $idea->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.ideas.show', $idea->id) }}" class="text-blue-600 hover:underline text-sm">Detail</a>
                            <a href="{{ route('admin.ideas.edit', $idea->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.ideas.destroy', $idea->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus ide ini?')" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 px-4 py-6">Tidak ada ide ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
