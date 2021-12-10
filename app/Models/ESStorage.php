<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ESStorage extends Model
{
    public $table = 'es_storage';

    protected $guarded = [];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

}
