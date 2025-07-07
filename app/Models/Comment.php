<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'is_solution',
        'commentable_id',
        'commentable_type',
        'parent_id',
    ];
    

    // Otomatis load user setiap ambil komentar
    protected $with = ['user', 'replies'];

    // Relasi polimorfik ke model yang dikomentari
    public function commentable()
    {
        return $this->morphTo();
    }

    // Relasi ke user pembuat komentar
    public function user()
{
    return $this->belongsTo(User::class);
}
public function replies()
{
    return $this->hasMany(Comment::class, 'parent_id');
}

public function parent()
{
    return $this->belongsTo(Comment::class, 'parent_id');
}

public function likes()
{
    return $this->hasMany(CommentLike::class);
}
    public function isReply()
{
    return !is_null($this->parent_id);
}
}
