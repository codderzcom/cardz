<?php

namespace App\Contexts\Auth\Application\Contracts;

use App\Contexts\Auth\Domain\Model\User\User;
use App\Contexts\Auth\Domain\Model\User\UserId;

interface UserRepositoryInterface
{
    public function persist(?User $user = null): void;

    public function take(UserId $userId): ?User;
}
