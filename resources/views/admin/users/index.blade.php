@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
    <h1 class="text-2xl font-bold mb-6">👥 Manajemen Pengguna</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="mb-4 flex gap-4">
    <a href="{{ route('admin.users.export.pdf') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        🧾 Export PDF
    </a>
</div>

    <table class="w-full bg-white rounded shadow overflow-hidden">
        <thead class="bg-gray-200 text-left">
            <tr>
                <th class="p-3">Nama</th>
                <th class="p-3">Email</th>
                <th class="p-3">Role</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3 capitalize">{{ $user->role }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
