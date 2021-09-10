<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $table = 'persons';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'joined_at' => 'datetime',
    ];
}
