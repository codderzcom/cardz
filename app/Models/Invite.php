<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    public $table = 'invites';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'proposed_at' => 'datetime',
    ];

}
