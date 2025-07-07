<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Comment;
use Illuminate\Http\Request;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::with('user')->latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::with(['user', 'comments.user'])->findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }
    public function updateComment(Request $request, Comment $comment)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    $comment->content = $request->content;
    $comment->save();

    return back()->with('success', 'Komentar berhasil diperbarui.');
}

}

