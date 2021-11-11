<?php

namespace App\Contexts\Auth\Domain\Persistence\Contracts;

use App\Contexts\Auth\Domain\Exceptions\UserNotFoundExceptionInterface;
use App\Contexts\Auth\Domain\Model\User\User;
use App\Contexts\Auth\Domain\Model\User\UserId;
use App\Contexts\Auth\Domain\Model\User\UserIdentity;

interface UserRepositoryInterface
{
    public function persist(User $user): void;

    public function isExistingIdentity(UserIdentity $userIdentity): bool;

    /**
     * @throws UserNotFoundExceptionInterface
     */
    public function takeByIdentity(string $identity): User;
}
