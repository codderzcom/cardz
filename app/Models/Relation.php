<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    public $table = 'relations';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'entered_at' => 'datetime',
        'left_at' => 'datetime',
    ];

}
