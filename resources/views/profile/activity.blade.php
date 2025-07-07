@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')
<div class="max-w-3xl mx-auto mt-8 space-y-4">
    <h1 class="text-2xl font-bold mb-4">📜 Riwayat Aktivitas</h1>

    {{-- Filter Dropdown --}}
    <div class="mb-4">
    <form method="GET" action="{{ route('profile.activity') }}">
        <select name="type" onchange="this.form.submit()" class="rounded border-gray-300">
            <option value="">Semua Aktivitas</option>
            <option value="idea" {{ request('type') == 'idea' ? 'selected' : '' }}>Ide</option>
            <option value="project" {{ request('type') == 'project' ? 'selected' : '' }}>Proyek</option>
            <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Produk</option>
            <option value="comment" {{ request('type') == 'comment' ? 'selected' : '' }}>Komentar</option>
        </select>
    </form>
</div>

    {{-- Daftar Aktivitas --}}
    @forelse($activities as $activity)
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-700">
                @if ($activity->subject && in_array(class_basename($activity->subject_type), ['Idea', 'Project', 'Product']))
                    @php
                        $routeName = match (class_basename($activity->subject_type)) {
                            'Idea' => 'ideas.show',
                            'Project' => 'projects.show',
                            'Product' => 'products.show',
                            default => null
                        };
                    @endphp

                    @if ($routeName)
                        <a href="{{ route($routeName, $activity->subject_id) }}" class="text-blue-600 hover:underline">
                            {{ $activity->description }}
                        </a>
                    @else
                        {{ $activity->description }}
                    @endif
                @else
                    {{ $activity->description }}
                @endif
            </p>
            <p class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p class="text-gray-500">Belum ada aktivitas.</p>
    @endforelse

    {{ $activities->appends(request()->query())->links() }}
</div>
@endsection
