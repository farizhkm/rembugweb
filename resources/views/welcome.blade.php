@extends('layouts.app')

@section('title', 'Beranda')

@section('hero')
<section class="relative bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 text-white py-20 overflow-hidden pb-16">
    <div class="max-w-7xl mx-auto px-4 text-center animate-fade-in">
        @auth
            <div class="flex justify-center mb-6">
                @if (Auth::user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover ring-2 ring-white shadow-lg">
                @else
                    <img src="{{ asset('default-profile.png') }}" alt="Foto Profil Default" class="w-20 h-20 rounded-full object-cover ring-2 ring-white shadow-lg">
                @endif
            </div>
            <p class="text-lg font-semibold">Halo, {{ Auth::user()->name }}!</p>
        @endauth
        <h1 class="text-5xl font-bold mb-4">RembugWeb</h1>
        <p class="text-xl mb-6">Tempat Kolaborasi & Solusi Masyarakat</p>
        <a href="{{ route('ideas.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-100 transition">Mulai Sekarang</a>
    </div>
    <div class="absolute bottom-0 w-full overflow-hidden leading-[0] rotate-180">
        <svg viewBox="0 0 500 50" preserveAspectRatio="none" class="relative block w-full h-[50px]">
            <path d="M0,0 C150,50 350,0 500,50 L500,0 L0,0 Z" class="fill-white"></path>
        </svg>
    </div>
</section>
@endsection

@section('content')
<!-- Fitur Ringkas -->
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
        <div class="transition transform hover:scale-105">
            <div class="text-blue-500 text-6xl mb-4">
                <i class="fas fa-lightbulb"></i>
            </div>
            <h3 class="text-2xl font-semibold mb-2">Ide & Diskusi</h3>
            <p class="text-gray-600 mb-4">Berbagi solusi dan gagasan dari masyarakat.</p>
            <a href="{{ route('ideas.index') }}" class="text-blue-600 font-medium">Lihat Ide</a>
        </div>
        <div class="transition transform hover:scale-105">
            <div class="text-green-500 text-6xl mb-4">
                <i class="fas fa-tasks"></i>
            </div>
            <h3 class="text-2xl font-semibold mb-2">Proyek Kolaborasi</h3>
            <p class="text-gray-600 mb-4">Bangun proyek nyata bersama komunitas.</p>
            <a href="{{ route('projects.index') }}" class="text-green-600 font-medium">Lihat Proyek</a>
        </div>
        <div class="transition transform hover:scale-105">
            <div class="text-yellow-500 text-6xl mb-4">
                <i class="fas fa-store"></i>
            </div>
            <h3 class="text-2xl font-semibold mb-2">UMKM Lokal</h3>
            <p class="text-gray-600 mb-4">Dukung bisnis kecil & menengah lokal.</p>
            <a href="{{ route('products.index') }}" class="text-yellow-600 font-medium">Lihat UMKM</a>
        </div>
    </div>
</section>

<!-- Ide Terbaru -->
<section class="bg-gray-50 py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">💡 Ide Terbaru</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($ideas as $idea)
                <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-xl transition">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $idea->title }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ $idea->description }}</p>
                        <a href="{{ route('ideas.show', $idea->id) }}" class="text-blue-500 text-sm mt-4 inline-block">Baca Selengkapnya</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Proyek Terbaru -->
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">🛠️ Proyek Terbaru</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($projects as $project)
                <div class="bg-gray-50 shadow-md rounded-xl overflow-hidden hover:shadow-xl transition">
                    <img src="/storage/{{ $project->image ?? 'default.jpg' }}" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ $project->description }}</p>
                        <a href="{{ route('projects.show', $project->id) }}" class="text-green-600 text-sm mt-4 inline-block">Detail Proyek</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- UMKM Terbaru -->
<section class="bg-gray-50 py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">🏪 UMKM Terbaru</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($umkms as $umkm)
                <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-xl transition">
                    <img src="/storage/{{ $umkm->image ?? 'default.jpg' }}" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $umkm->name }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ $umkm->description }}</p>
                        <a href="{{ route('products.show', $umkm->id) }}" class="text-yellow-600 text-sm mt-4 inline-block">Detail UMKM</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
