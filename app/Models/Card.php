<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    public $table = 'cards';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'issued_at' => 'datetime',
        'satisfied_at' => 'datetime',
        'completed_at' => 'datetime',
        'revoked_at' => 'datetime',
        'blocked_at' => 'datetime',
        'achievements' => 'array',
        'requirements' => 'array',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

}
