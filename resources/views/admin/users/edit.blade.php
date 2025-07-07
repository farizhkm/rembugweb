@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
    <h1 class="text-2xl font-bold mb-6">✏️ Edit Pengguna</h1>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Role</label>
            <select name="role" class="w-full border px-3 py-2 rounded" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
        <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600 hover:underline">Kembali</a>
    </form>
@endsection
