<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public $table = 'cards';
    public $incrementing = false;

    protected $guarded = [];
    protected $casts = [
        'issued_at' => 'datetime',
        'completed_at' => 'datetime',
        'revoked_at' => 'datetime',
        'blocked_at' => 'datetime',
    ];
}
