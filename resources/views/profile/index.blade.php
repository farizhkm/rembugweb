@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Profil Saya</h1>

    <div class="flex items-center gap-6 mb-6">
        {{-- Foto Profil --}}
        @php
            $profilePicture = $user->profile_picture 
                ? asset('storage/' . $user->profile_picture) 
                : asset('default-profile.png'); // fallback default jika tidak ada
        @endphp

        <img src="{{ $profilePicture }}" alt="Foto Profil"
            class="w-20 h-20 rounded-full object-cover border border-gray-300 shadow">

        <div>
            <p class="text-lg font-semibold">{{ $user->name }}</p>
            <p class="text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    <div class="space-y-3 text-sm text-gray-700">
        <p><span class="font-medium">📍 Alamat:</span> {{ $user->address ?? '-' }}</p>
        <p><span class="font-medium">📞 Nomor Telepon:</span> {{ $user->phone_number ?? '-' }}</p>
        <p><span class="font-medium">📝 Bio:</span> {{ $user->bio ?? '-' }}</p>
        <p><span class="font-medium">🎂 Tanggal Lahir:</span>
            {{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->translatedFormat('d F Y') : '-' }}
        </p>
    </div>
</div>
@endsection
