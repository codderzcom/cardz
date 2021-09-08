<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public $table = 'plans';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'requirements' => 'array',
        'added_at' => 'datetime',
        'launched_at' => 'datetime',
        'stopped_at' => 'datetime',
        'archived_at' => 'datetime',
    ];
}
