<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
    // Ambil semua kategori unik dari database
    $categories = Idea::select('category')->distinct()->get();

    // Tentukan status yang valid
    $statuses = ['pending', 'approved', 'rejected']; // Pastikan ini sesuai dengan status yang ada di database

    // Ambil ide-ide yang ada dan terapkan pencarian dan filter sesuai permintaan
    $ideas = Idea::with('user')
        ->when($request->search, function ($query) use ($request) {
            return $query->where('title', 'like', '%'.$request->search.'%');
        })
        ->when($request->category, function ($query) use ($request) {
            return $query->where('category', $request->category);
        })
        ->when($request->status && in_array($request->status, $statuses), function ($query) use ($request) {
            return $query->where('status', $request->status);
        })
        ->latest()
        ->paginate(10);

    // Kirim kategori, ide, dan status ke view
    return view('ideas.index', compact('ideas', 'categories', 'statuses'));
    }
    public function create()
    {
    // Ambil semua kategori unik dari database
    $categories = Idea::select('category')->distinct()->get();

    // Tentukan status yang valid
    $statuses = ['pending', 'approved', 'rejected']; // Daftar status yang valid

    // Kirim kategori dan status ke view 'ideas.create'
    return view('ideas.create', compact('categories', 'statuses'));
    }

   public function store(Request $request)
{
    // Validasi inputan
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'status' => 'required|in:pending,approved,rejected',
        'description' => 'required|string',
        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',
        'image' => 'nullable|image|max:2048',
    ]);

    $idea = new Idea($request->all());

    // Jika ada file gambar
    if ($request->hasFile('image')) {
        $idea->image = $request->file('image')->store('ideas', 'public');
    }

    // Tambahkan user_id lalu simpan
    $idea->user_id = auth()->id();
    $idea->save(); // ⬅️ Pastikan disimpan dulu

    // Simpan aktivitas setelah ID tersedia
    \App\Models\Activity::create([
        'user_id' => auth()->id(),
        'action' => 'created_idea',
        'subject_type' => \App\Models\Idea::class,
        'subject_id' => $idea->id,
        'description' => 'Membuat ide baru: ' . $idea->title,
    ]);

    return redirect()->route('ideas.show', $idea)->with('success', 'Ide berhasil dibuat.');
}

   public function show(Idea $idea)
{
    $idea->load(['comments.user', 'comments.replies.user']); // WAJIB ini!
    return view('ideas.show', compact('idea'));
}


        public function edit(Idea $idea)
    {
    if (auth()->id() !== $idea->user_id) {
        return redirect()->route('ideas.index')->with('error', 'Anda tidak diizinkan melakukan aksi ini.');
    }

    return view('ideas.edit', compact('idea'));
    }

    public function update(Request $request, Idea $idea)
    {
         if (auth()->id() !== $idea->user_id) {
        return redirect()->route('ideas.index')->with('error', 'Anda tidak diizinkan melakukan aksi ini.');
         }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'category' => 'nullable|string',
            'status' => 'in:pending,approved,rejected',
        ]);

        if ($request->hasFile('image')) {
            $idea->image = $request->file('image')->store('ideas', 'public');
        }

        $idea->update($request->except('image'));

        return redirect()->route('ideas.show', $idea)->with('success', 'Ide berhasil diperbarui.');
    }

    public function destroy(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
        return redirect()->route('ideas.index')->with('error', 'Anda tidak diizinkan melakukan aksi ini.');
        }

        $idea->delete();

        return redirect()->route('ideas.index')->with('success', 'Ide berhasil dihapus.');
    }
    public function vote(Idea $idea)
    {
        $idea->increment('votes');
        return response()->json(['success' => true, 'votes' => $idea->votes]);
    }
    public function __construct()
    {
    $this->middleware('auth');
    }
}