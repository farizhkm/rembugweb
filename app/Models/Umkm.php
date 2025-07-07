<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Umkm extends Model
{
    public function products()
{
    return $this->hasMany(Product::class);
}
protected $fillable = ['user_id'];

public function user()
{
    return $this->belongsTo(User::class);
}
public function comments()
{
    return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->latest();
}
}
