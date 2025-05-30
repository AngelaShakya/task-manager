<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Project extends Model
{
    protected $fillable = [
        'name'
    ];

    //Project has many tasks
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
