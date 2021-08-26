<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public $table = 'achievements';
    public $incrementing = false;

    protected $guarded = [];
    protected $casts = [
        'added_at' => 'datetime',
        'removed_at' => 'datetime',
    ];
}
