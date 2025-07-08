<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
 
    <div class="min-h-screen flex">
        <aside class="w-64 bg-gradient-to-b from-blue-700 to-blue-800 text-white shadow-lg">
            <div class="p-4 text-xl font-bold border-b border-blue-600">
                ✨ Admin Panel
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-600 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
                    📊 <span>Statistik</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-600 {{ request()->routeIs('admin.users.index') ? 'bg-blue-600' : '' }}">
                    📊 <span>Manajemen User</span>
                </a>
                <a href="{{ route('admin.ideas.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-600 {{ request()->routeIs('admin.ideas.*') ? 'bg-blue-600' : '' }}">
                    💡 <span>Ide</span>
                </a>
                <a href="{{ route('admin.projects.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-600 {{ request()->routeIs('admin.projects.*') ? 'bg-blue-600' : '' }}">
                    🏗️ <span>Proyek</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-600 {{ request()->routeIs('admin.products.*') ? 'bg-blue-600' : '' }}">
                    🛍️ <span>Produk UMKM</span>
                </a>
                <a href="{{ route('admin.activities.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-600 {{ request()->routeIs('admin.activities.*') ? 'bg-blue-600' : '' }}">
                    📝 <span>Aktivitas</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-6">
            {{-- Header Bar --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-xl font-semibold text-gray-800">📋 Panel Admin</h1>

    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-600">
            👤 {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded">
                Keluar
            </button>
        </form>
    </div>
</div>

            @yield('content')
        </main>
    </div>

</body>
</html>
