@extends('layouts.app')

@section('title', 'Ide & Diskusi')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ide & Diskusi</h1>
        @auth
            <a href="{{ route('ideas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fa fa-plus mr-2"></i> Tambah Ide
            </a>
        @endauth
    </div>

    <!-- Pencarian dan Filter -->
    <form method="GET" action="{{ route('ideas.index') }}" class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="flex-1 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="🔍 Cari ide berdasarkan judul, deskripsi..." 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-10"
                >
                <i class="fa fa-search absolute top-2.5 left-3 text-gray-400"></i>
            </div>

            <div>
                <select name="category" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-300">
                    Cari
                </button>
            </div>
        </div>
    </form>

    <!-- Daftar Ide -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($ideas as $idea)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col h-full">
                @if ($idea->image)
                    <img src="{{ asset('storage/' . $idea->image) }}" alt="{{ $idea->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Tidak ada gambar</span>
                    </div>
                @endif

                <div class="p-5 flex flex-col justify-between flex-1">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $idea->title }}</h2>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($idea->description, 90) }}</p>

                        {{-- Link Google Maps jika ada --}}
                        @if ($idea->lat && $idea->lng)
                            <a href="https://www.google.com/maps?q={{ $idea->lat }},{{ $idea->lng }}" 
                               target="_blank" 
                               class="text-sm text-green-600 hover:underline block mb-2">
                               📍 Buka Lokasi di Google Maps
                            </a>
                        @endif

                        <div class="text-sm text-gray-500 mb-2">
                            <p>Oleh: <strong>{{ $idea->user->name }}</strong></p>
                            <p>Dibuat: {{ $idea->created_at->format('d M Y') }}</p>
                        </div>

                        @if ($idea->category)
                            <span class="inline-block mb-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">{{ $idea->category }}</span>
                        @endif
                        @if ($idea->status)
                            <span class="ml-2 inline-block px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $idea->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($idea->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($idea->status) }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('ideas.show', $idea) }}" class="text-blue-600 hover:underline font-medium text-sm">
                            🔍 Lihat Detail Ide
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center">Belum ada ide. Ayo tambahkan ide pertama!</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $ideas->appends(request()->query())->links() }}
    </div>
</div>
@endsection
