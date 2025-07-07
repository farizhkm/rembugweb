@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <h1 class="text-2xl font-bold mb-6">📊 Dashboard Admin</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        {{-- Total Ide --}}
        <div x-data="{ open: false }" class="bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center">
                <h2 class="text-gray-600 text-sm">Total Ide</h2>
                <button @click="open = !open" class="text-blue-500 text-xs hover:underline">
                    <span x-show="!open">Lihat Daftar ↓</span>
                    <span x-show="open">Tutup ↑</span>
                </button>
            </div>
            <p class="text-3xl font-bold text-blue-600 mb-2">{{ $totalIdeas }}</p>
            <div x-show="open" class="text-sm max-h-40 overflow-y-auto border-t pt-2 space-y-1">
                @foreach ($ideas as $idea)
                    <p class="text-gray-700">{{ $idea->title }}</p>
                @endforeach
            </div>
        </div>
                {{-- Grafik Aktivitas --}}
        <div class="bg-white p-6 rounded shadow mb-10">
            <h2 class="text-lg font-bold mb-4">📈 Aktivitas 7 Hari Terakhir</h2>
            <canvas id="activityChart" height="100"></canvas>
        </div>
        {{-- Total Proyek --}}
        <div x-data="{ open: false }" class="bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center">
                <h2 class="text-gray-600 text-sm">Total Proyek</h2>
                <button @click="open = !open" class="text-green-500 text-xs hover:underline">
                    <span x-show="!open">Lihat Daftar ↓</span>
                    <span x-show="open">Tutup ↑</span>
                </button>
            </div>
            <p class="text-3xl font-bold text-green-600 mb-2">{{ $totalProjects }}</p>
            <div x-show="open" class="text-sm max-h-40 overflow-y-auto border-t pt-2 space-y-1">
                @foreach ($projects as $project)
                    <p class="text-gray-700">{{ $project->title }}</p>
                @endforeach
            </div>
        </div>

        {{-- Total Produk UMKM --}}
        <div x-data="{ open: false }" class="bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center">
                <h2 class="text-gray-600 text-sm">Produk UMKM</h2>
                <button @click="open = !open" class="text-yellow-600 text-xs hover:underline">
                    <span x-show="!open">Lihat Daftar ↓</span>
                    <span x-show="open">Tutup ↑</span>
                </button>
            </div>
            <p class="text-3xl font-bold text-yellow-600 mb-2">{{ $totalProducts }}</p>
            <div x-show="open" class="text-sm max-h-40 overflow-y-auto border-t pt-2 space-y-1">
                @foreach ($products as $product)
                    <p class="text-gray-700">{{ $product->name }}</p>
                @endforeach
            </div>
        </div>

        {{-- Total Komentar --}}
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-600 text-sm">Total Komentar</h2>
            <p class="text-3xl font-bold text-purple-600">{{ $totalComments }}</p>
        </div>

        {{-- Total Pengguna --}}
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-600 text-sm">Total Pengguna</h2>
            <p class="text-3xl font-bold text-pink-600">{{ $totalUsers }}</p>
        </div>
    </div>

    {{-- Aktivitas Terbaru & User Baru --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Aktivitas Terbaru --}}
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">🕘 Aktivitas Terbaru</h2>
            @forelse ($recentActivities as $activity)
                <div class="mb-2 border-b pb-2">
                    <p class="text-sm">
                        <span class="font-semibold text-blue-700">{{ $activity->user->name ?? 'Pengguna' }}</span>
                        <span>{{ $activity->description }}</span>
                    </p>
                    <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada aktivitas.</p>
            @endforelse
        </div>

        {{-- Pengguna Terbaru --}}
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">👥 Pengguna Terbaru</h2>
            <ul>
                @forelse ($latestUsers as $user)
                    <li class="mb-2 border-b pb-2">
                        <p class="text-sm font-semibold">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                    </li>
                @empty
                    <p class="text-sm text-gray-500">Belum ada pengguna baru.</p>
                @endforelse
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('activityChart').getContext('2d');
    const activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($activityChart->pluck('date')),
            datasets: [{
                label: 'Jumlah Aktivitas',
                data: @json($activityChart->pluck('total')),
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                tension: 0.3,
                fill: true,
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
<form action="{{ route('admin.dashboard.export.pdf') }}" method="GET" class="flex items-center gap-2 mb-4">
    <label for="start_date">Dari:</label>
    <input type="date" name="start_date" class="border rounded px-2 py-1" required>
    <label for="end_date">Sampai:</label>
    <input type="date" name="end_date" class="border rounded px-2 py-1" required>
    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded">
        Export PDF
    </button>
</form>
@endsection
