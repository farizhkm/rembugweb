@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Lupa Password</h2>

    <p class="text-sm text-gray-600 mb-4">
        Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password.
    </p>

    @if (session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                   required autofocus>
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                Kirim Link Reset
            </button>
        </div>
    </form>
</div>
@endsection
