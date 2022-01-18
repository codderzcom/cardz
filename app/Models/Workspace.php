<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    public $table = 'workspaces';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'added_at' => 'datetime',
        'profile' => 'array',
    ];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }
}
