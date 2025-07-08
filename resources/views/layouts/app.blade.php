<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>@yield('title', 'Platform Kolaborasi Masyarakat') - {{ config('app.name', 'RembugWeb') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Inter', sans-serif;
        }
        .bg-rembug-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
        }
        .comment-new {
            animation: fade-in 0.6s ease-out;
        }
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col">
    <nav class="bg-white shadow-sm border-b border-gray-200 fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-1">
                        <span class="text-2xl font-bold text-blue-600">Rembug</span>
                        <span class="text-2xl font-bold text-green-600">Web</span>
                    </a>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <x-nav-link route="dashboard" icon="fa-home">Beranda</x-nav-link>
                        <x-nav-link route="ideas.index" icon="fa-lightbulb">Ide & Diskusi</x-nav-link>
                        <x-nav-link route="projects.index" icon="fa-tasks">Proyek</x-nav-link>
                        <x-nav-link route="map.index" icon="fa-map-marker-alt">Peta</x-nav-link>
                        <x-nav-link route="products.index" icon="fa-store">UMKM</x-nav-link>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center">
                    @auth
                        <div x-data="{ open: false }" class="relative ml-3">
                            <button @click="open = !open" class="flex text-sm rounded-full">
                                @php
                                    $user = auth()->user();
                                    $profilePicture = $user->profile_picture 
                                        ? asset('storage/' . $user->profile_picture) 
                                        : asset('default-profile.png');
                                @endphp
                                <img class="h-8 w-8 rounded-full object-cover ring-1 ring-gray-300" 
                                     src="{{ $profilePicture }}" 
                                     alt="{{ $user->name }}">
                            </button>
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="block px-4 py-2 text-sm text-gray-900 font-semibold">
                                    {{ $user->name }}
                                </div>
                                <hr class="my-1">
                                @if($user->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-red-600 font-semibold hover:bg-gray-100">🔧 Halaman Admin</a>
                                @endif
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <a href="{{ route('profile.activity') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Riwayat Aktivitas</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium ml-2">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('hero')
    <main class="pt-24 flex-grow">
        @yield('header')
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </main>

    <x-footer-section />

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
