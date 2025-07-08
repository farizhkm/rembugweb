@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Daftar di RembugWeb</h2>

        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('status') }}
            </div>
        @endif
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 mb-6 rounded shadow" role="alert">
                ⚠️ <strong>Perhatian:</strong> Mohon isi data dengan benar dan lengkap. Informasi yang Anda daftarkan akan digunakan secara permanen di sistem.
            </div>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div>
            <x-input-label for="profile_picture" value="Foto Profil" />
            <input id="profile_picture" type="file" name="profile_picture" accept="image/* "accept="image/*" max="2048"
                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <img id="preview" class="mt-2 w-24 h-24 rounded-full object-cover hidden">
            @error('profile_picture')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
        </div>

        <script>
            const input = document.getElementById('profile_picture');
            const preview = document.getElementById('preview');

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('hidden');
                }
            });
        </script>
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                    required
                    autofocus
                    autocomplete="name"
                >
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                    required
                    autocomplete="username"
                >
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
          <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
            <input id="address" type="text" name="address" value="{{ old('address') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                @error('address')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
        </div>


        <div>
            <x-input-label for="phone_number" value="Nomor Telepon" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" />
                    @error('phone_number')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
        </div>

        <div>
            <x-input-label for="bio" value="Bio / Deskripsi Singkat" />
            <textarea id="bio" name="bio" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('bio') }}</textarea>
                @error('bio')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
        </div>

        <div>
            <x-input-label for="birthdate" value="Tanggal Lahir (Opsional)" />
            <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" />
        @error('birthdate')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
        </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required
                    autocomplete="new-password"
                >
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                    Sudah punya akun? Login
                </a>
                <button
                    type="submit"
                    class="ml-3 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md"
                >
                    Daftar
                </button>
            </div>
        </form>
    </div>
@endsection