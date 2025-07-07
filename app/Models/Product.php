<?php

namespace App\Models;
use App\Models\Comment;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function umkm()
{
    return $this->belongsTo(UMKM::class);
}
protected $fillable = [
    'umkm_id',
    'name',
    'description',
    'price',
    'image',
    'whatsapp_number',
    'latitude',
    'longitude',
];
public function user()
{
    return $this->belongsTo(User::class);
}

public function comments()
{
    return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->latest();
}

}
