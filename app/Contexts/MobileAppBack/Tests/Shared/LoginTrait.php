<?php

namespace App\Contexts\MobileAppBack\Tests\Shared;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait LoginTrait
{
    protected function login(string $userId)
    {
        /** @var User $user */
        $user = User::query()->find($userId);
        Auth::login($user);
    }
}
