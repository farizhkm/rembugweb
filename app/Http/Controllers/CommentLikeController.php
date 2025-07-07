<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function toggle(Comment $comment)
    {
        $user = Auth::user();

        if ($comment->user_id === $user->id) {
    return response()->json(['error' => 'Tidak bisa like komentar sendiri.'], 403);
}

        // Cek apakah user sudah pernah like
        $like = CommentLike::where('comment_id', $comment->id)
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            // Jika sudah like, hapus (unlike)
            $like->delete();
            $status = 'unliked';
        } else {
            // Jika belum like, buat like
            CommentLike::create([
                'user_id' => $user->id,
                'comment_id' => $comment->id,
            ]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'likes_count' => $comment->likes()->count()
        ]);
    }
    public function __construct()
{
    $this->middleware('auth');
}
}
