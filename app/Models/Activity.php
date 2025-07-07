<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'action', 'subject_type', 'subject_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo(__FUNCTION__, 'subject_type', 'subject_id');
    }
    
}
