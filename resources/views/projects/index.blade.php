@extends('layouts.app')

@section('title', 'Daftar Proyek')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Proyek</h1>
        @auth
            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fa fa-plus mr-2"></i> Tambah Proyek
            </a>
        @endauth
    </div>

    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari proyek..." class="border-gray-300 rounded-md shadow-sm w-full">

        <select name="category" class="border-gray-300 rounded-md shadow-sm w-full">
            <option value="">Semua Kategori</option>
            @foreach ($allCategories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
            @endforeach
        </select>

        <select name="status" class="border-gray-300 rounded-md shadow-sm w-full">
            <option value="">Semua Status</option>
            <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projects as $project)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col justify-between min-h-[480px]">
    @if ($project->image)
        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
    @endif

    <div class="p-5 flex flex-col justify-between flex-grow">
        <div class="flex-grow">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $project->title }}</h3>
            @if($project->category)
                <span class="text-xs inline-block mb-2 px-2 py-1 bg-blue-100 text-blue-700 rounded">{{ ucfirst($project->category) }}</span>
            @endif

            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($project->description, 80) }}</p>

            @if ($project->lat && $project->lng)
                <a href="https://www.google.com/maps?q={{ $project->lat }},{{ $project->lng }}" target="_blank" 
                   class="inline-block mb-2 text-green-700 text-sm hover:underline">
                    📍 Buka Lokasi di Google Maps
                </a>
            @endif

            @if ($project->items && $project->items->count())
                <div class="mt-2">
                    <p class="text-sm font-medium text-gray-700 mb-1">Alat / Bahan Dibutuhkan:</p>
                    <ul class="list-disc list-inside text-sm text-gray-600">
                        @foreach ($project->items->take(3) as $item)
                            <li>{{ $item->name }}</li>
                        @endforeach
                        @if ($project->items->count() > 3)
                            <li><em>dan {{ $project->items->count() - 3 }} lainnya...</em></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>

        <div class="mt-4 text-sm text-gray-500">
            <p>Dibuat oleh: <strong>{{ $project->user->name }}</strong></p>
            <p>Mulai: {{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</p>
            <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full 
                {{ $project->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' :
                   ($project->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($project->status) }}
            </span>

            <div class="mt-3">
                <a href="{{ route('projects.show', $project) }}" 
                   class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-md text-sm hover:bg-blue-200 transition">
                    🔍 Lihat Detail Proyek
                </a>
            </div>
        </div>
    </div>
</div>
        @empty
            <p class="text-gray-500 col-span-full text-center">Belum ada proyek.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $projects->links() }}
    </div>
</div>
@endsection
