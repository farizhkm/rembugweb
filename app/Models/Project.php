<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;


class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category',
        'address',
        'lat',
        'lng',
        'needs',
        'start_date',
        'end_date',
        'status',
        'user_id', // jangan lupa jika ada kolom ini di database
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->latest();
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
    public function items()
    {
    return $this->hasMany(ProjectItem::class);
    }
}
