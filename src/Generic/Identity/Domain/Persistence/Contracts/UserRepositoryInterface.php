<?php

namespace Cardz\Generic\Identity\Domain\Persistence\Contracts;

use Cardz\Generic\Identity\Domain\Exceptions\UserNotFoundExceptionInterface;
use Cardz\Generic\Identity\Domain\Model\User\User;
use Cardz\Generic\Identity\Domain\Model\User\UserIdentity;

interface UserRepositoryInterface
{
    public function persist(User $user): void;

    public function isExistingIdentity(UserIdentity $userIdentity): bool;

    /**
     * @throws UserNotFoundExceptionInterface
     */
    public function takeByIdentity(string $identity): User;
}
