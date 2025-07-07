<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectItem extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'is_available',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contributions()
    {
        return $this->hasMany(ItemContribution::class);
    }
}

