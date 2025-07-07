<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;
use App\Models\Comment;

class IdeaAdminController extends Controller
{
    public function index()
    {
        $ideas = Idea::latest()->get();
        return view('admin.ideas.index', compact('ideas'));
    }

    public function edit($id)
    {
        $idea = Idea::findOrFail($id);
        return view('admin.ideas.edit', compact('idea'));
    }

    public function update(Request $request, $id)
    {
        $idea = Idea::findOrFail($id);
        $idea->update($request->all());

        return redirect()->route('admin.ideas.index')->with('success', 'Ide berhasil diperbarui.');
    }

    public function destroy($id)
{
    $idea = Idea::findOrFail($id);
    $idea->delete();

    return redirect()->route('admin.ideas.index')->with('success', 'Ide berhasil dihapus.');
}

        public function show($id)
        {
            // Ambil ide dan relasi komentar + user-nya
            $idea = Idea::with(['comments.user', 'user'])->findOrFail($id);

            return view('admin.ideas.show', compact('idea'));
        }
}

