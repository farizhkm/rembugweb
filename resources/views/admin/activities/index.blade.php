@extends('layouts.admin')

@section('title', 'Aktivitas Pengguna')

@section('content')
    <h1 class="text-2xl font-bold mb-6">📜 Riwayat Aktivitas Pengguna</h1>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Pencarian --}}
    <form method="GET" action="{{ route('admin.activities.index') }}" class="mb-6">
        <div class="flex flex-col sm:flex-row items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari aktivitas, tindakan, atau user..." class="w-full sm:w-1/3 border px-4 py-2 rounded" />
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                🔍 Cari
            </button>
        </div>
    </form>

    {{-- Tabel Aktivitas --}}
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">🧑‍💻 Pengguna</th>
                    <th class="px-4 py-3 text-left">🎯 Aksi</th>
                    <th class="px-4 py-3 text-left">📝 Deskripsi</th>
                    <th class="px-4 py-3 text-left">🕒 Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $activity)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 font-semibold">
                            {{ $activity->user->name ?? 'User dihapus' }}
                        </td>
                        <td class="px-4 py-2">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                {{ $activity->action }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $activity->description }}</td>
                        <td class="px-4 py-2 text-gray-500">
                            {{ $activity->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada aktivitas ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $activities->withQueryString()->links() }}
    </div>
@endsection
