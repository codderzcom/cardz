<?php

namespace App\Contexts\Auth\Infrastructure\Persistence\Contracts;

use App\Contexts\Auth\Domain\Model\User\User;
use App\Contexts\Auth\Domain\Model\User\UserId;
use App\Contexts\Auth\Domain\Model\User\UserIdentity;

interface UserRepositoryInterface
{
    public function persist(User $user): void;

    public function take(UserId $userId): User;

    public function isExistingIdentity(UserIdentity $userIdentity): bool;

    public function takeWithAmbiguousIdentity(string $identity): User;
}
