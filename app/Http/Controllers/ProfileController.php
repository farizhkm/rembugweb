<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function index()
{
    $user = auth()->user();
    return view('profile.index', compact('user'));
} // Tampilkan form edit profil

        public function edit()
        {
            $user = auth()->user(); // ambil user yang sedang login
            return view('profile.edit', compact('user')); // <-- ini penting!
        }
    // Simpan perubahan profil
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'birthdate' => 'nullable|date',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        // Simpan foto profil jika diunggah
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    // Hapus akun pengguna
    public function destroy(Request $request)
    {
        $request->user()->delete();

        return redirect()->route('welcome')->with('success', 'Akun berhasil dihapus.');
    }
    public function activity()
{
    $activities = auth()->user()->activities()->latest()->paginate(10);
    return view('profile.activity', compact('activities'));
}
}
