<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    public $table = 'relations';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'established_at' => 'datetime',
    ];

}
