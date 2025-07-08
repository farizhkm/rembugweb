@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-16">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Masuk ke RembugWeb</h2>

    @if (session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                required autofocus autocomplete="username">
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                required autocomplete="current-password">
            @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center mb-4">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
        </div>

        <div class="flex items-center justify-between mb-2">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                    Lupa Password?
                </a>
            @endif

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md transition">
                Login
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Daftar sekarang</a>
            </p>
        </div>
    </form>
</div>
@endsection
