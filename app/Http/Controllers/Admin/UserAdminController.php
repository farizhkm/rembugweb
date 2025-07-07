<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only(['name', 'role']));

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

public function exportPDF()
{
    $users = User::select('id', 'name', 'email', 'role', 'created_at')->get();
    $pdf = PDF::loadView('admin.users.export-pdf', compact('users'));

    return $pdf->download('daftar_pengguna.pdf');
}

}
