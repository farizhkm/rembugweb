<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectItem;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $query = Project::query()->with('user');

    // Filter: Pencarian
    if ($search = $request->search) {
        $query->where('title', 'like', "%{$search}%");
    }

    // Filter: Kategori
    if ($category = $request->category) {
        $query->where('category', $category);
    }

    // Filter: Status
    if ($status = $request->status) {
        $query->where('status', $status);
    }

    // Ambil data proyek dan kategori unik
    $projects = $query->latest()->paginate(9)->withQueryString();
    $allCategories = Project::select('category')->distinct()->pluck('category')->filter()->unique();

    return view('projects.index', compact('projects', 'allCategories'));
}


    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'category'    => 'nullable|string|max:255',
        'address'     => 'nullable|string',
        'lat'         => 'nullable|numeric',
        'lng'         => 'nullable|numeric',
        'start_date'  => 'nullable|date',
        'end_date'    => 'nullable|date',
        'status'      => 'required|in:ongoing,completed,cancelled',
        'image'       => 'nullable|image|max:2048',
        'tools.*'     => 'nullable|string|max:255',
    ]);

    // Buat project baru
    $project = new Project($request->except('image', 'tools'));
    $project->user_id = auth()->id();

    // Upload gambar jika ada
    if ($request->hasFile('image')) {
        $project->image = $request->file('image')->store('projects', 'public');
    }

    $project->save();

    // Simpan alat/bahan jika ada
    if ($request->has('tools')) {
        foreach ($request->tools as $toolName) {
            $trimmed = trim($toolName);
            if ($trimmed !== '') {
                \App\Models\ProjectItem::create([
                    'project_id'   => $project->id,
                    'name'         => $trimmed,
                    'is_available' => false,
                ]);
            }
        }
    }

    // Simpan riwayat aktivitas
    \App\Models\Activity::create([
        'user_id'     => auth()->id(),
        'action'      => 'created_project',
        'subject_type'=> \App\Models\Project::class,
        'subject_id'  => $project->id,
        'description' => 'Membuat proyek: ' . $project->title,
    ]);

    return redirect()->route('projects.show', $project)->with('success', 'Proyek berhasil dibuat.');
}

    public function show(Project $project)
    {
        $project->load(['comments.user', 'comments.replies.user']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
{
    /** @var \App\Models\Project $project */
    if (auth()->id() !== $project->user_id) {
        return redirect()->route('projects.index')->with('error', 'Anda tidak diizinkan mengedit proyek ini.');
    }

    $project->load('items');
    return view('projects.edit', compact('project'));
}

    public function update(Request $request, Project $project)
{
    /** @var \App\Models\Project $project */
    if (auth()->id() !== $project->user_id) {
        return redirect()->route('projects.index')->with('error', 'Anda tidak diizinkan mengupdate proyek ini.');
    }

    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'category'    => 'nullable|string|max:255',
        'address'     => 'nullable|string',
        'lat'         => 'nullable|numeric',
        'lng'         => 'nullable|numeric',
        'start_date'  => 'nullable|date',
        'end_date'    => 'nullable|date',
        'status'      => 'required|in:ongoing,completed,cancelled',
        'image'       => 'nullable|image|max:2048',
        'tools.*'     => 'nullable|string|max:255',
    ]);

    $project->fill($request->except('image', 'tools'));

    if ($request->has('tools')) {
        $project->needs = implode(',', array_filter($request->tools));
    }

    if ($request->hasFile('image')) {
        $project->image = $request->file('image')->store('projects', 'public');
    }

    $project->save();

    return redirect()->route('projects.show', $project)->with('success', 'Proyek berhasil diperbarui.');
}


    public function destroy(Project $project)
{
    /** @var \App\Models\Project $project */
    if (auth()->id() !== $project->user_id) {
        return redirect()->route('projects.index')->with('error', 'Anda tidak diizinkan menghapus proyek ini.');
    }

    $project->delete();

    return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus.');
}

}
