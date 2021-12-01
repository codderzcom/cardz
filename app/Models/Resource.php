<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public $table = 'resources';

    protected $guarded = [];

    protected $primaryKey = ['resource_id', 'resource_type'];

    public $incrementing = false;

    protected $casts = [
        'attributes' => 'array',
    ];
}
