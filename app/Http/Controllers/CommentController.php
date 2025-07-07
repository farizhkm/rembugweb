<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\Project;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function store(Request $request, $model, $id)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $modelClass = $this->resolveModelClass($model);

    if (!$modelClass || !class_exists($modelClass)) {
        return abort(404, 'Model tidak dikenali.');
    }

    $commentable = $modelClass::findOrFail($id);

    $comment = $commentable->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->content,
    ]);

    // ✅ Catat aktivitas komentar
    \App\Models\Activity::create([
        'user_id' => auth()->id(),
        'action' => 'created_comment',
        'subject_type' => get_class($commentable),
        'subject_id' => $commentable->id,
        'description' => 'Mengomentari ' . class_basename($commentable) . ': ' . ($commentable->title ?? $commentable->name ?? '[Tanpa Judul]'),
    ]);

    // Untuk Ajax request
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'comment' => $comment->load('user'),
        ]);
    }

    return back()->with('success', 'Komentar berhasil ditambahkan.');
}

private function resolveModelClass($model)
{
    $map = [
        'ideas' => \App\Models\Idea::class,
        'projects' => \App\Models\Project::class,
        'products' => \App\Models\Product::class,
    ];

    return $map[$model] ?? null;
}


    // Menghapus komentar
    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id) {
    return response()->json(['success' => false, 'message' => 'Unauthorized']);
}

        $comment->delete();

        return response()->json(['success' => true, 'message' => 'Komentar dihapus']);
    }

    // Voting komentar
    public function vote(Request $request, Comment $comment)
    {
        if (auth()->id() === $comment->user_id) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa vote komentar sendiri'], 400);
        }

        $comment->increment('votes');

        return response()->json(['success' => true, 'votes' => $comment->votes]);
    }
    // app/Http/Controllers/CommentController.php
    public function update(Request $request, Comment $comment)
{
    $user = auth()->user();

    // Admin atau pemilik komentar boleh edit
    if ($user->id !== $comment->user_id && $user->role !== 'admin') {
        abort(403, 'Tidak diizinkan.');
    }

    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $comment->content = $request->content;
    $comment->save();

    return back()->with('success', 'Komentar berhasil diperbarui.');
}

public function reply(Request $request, Comment $comment)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    $reply = new Comment([
        'content'   => $request->content,
        'user_id'   => auth()->id(),
        'parent_id' => $comment->id,
    ]);

    $commentable = $comment->commentable;
    $commentable->comments()->save($reply);

    // ✅ Catat aktivitas membalas komentar
    \App\Models\Activity::create([
        'user_id' => auth()->id(),
        'action' => 'replied_comment',
        'subject_type' => get_class($commentable),
        'subject_id' => $commentable->id,
        'description' => 'Membalas komentar pada ' . class_basename($commentable) . ': ' . ($commentable->title ?? $commentable->name ?? '[Tanpa Judul]'),
    ]);

    return back()->with('success', 'Balasan berhasil dikirim!');
}
}
