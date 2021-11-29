<?php

namespace App\Contexts\Identity\Domain\Persistence\Contracts;

use App\Contexts\Identity\Domain\Exceptions\UserNotFoundExceptionInterface;
use App\Contexts\Identity\Domain\Model\User\User;
use App\Contexts\Identity\Domain\Model\User\UserIdentity;

interface UserRepositoryInterface
{
    public function persist(User $user): void;

    public function isExistingIdentity(UserIdentity $userIdentity): bool;

    /**
     * @throws UserNotFoundExceptionInterface
     */
    public function takeByIdentity(string $identity): User;
}
