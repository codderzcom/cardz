<?php

namespace Cardz\Generic\Identity\Tests\Support\Mocks;

use Cardz\Generic\Identity\Domain\Model\User\User;
use Cardz\Generic\Identity\Domain\Model\User\UserIdentity;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Infrastructure\Exceptions\UserNotFoundException;

class UserInMemoryRepository implements UserRepositoryInterface
{

    protected static array $storage = [];

    public function persist(User $user): void
    {
        static::$storage[(string) $user->identity] = $user;
    }

    public function isExistingIdentity(UserIdentity $userIdentity): bool
    {
        return array_key_exists((string) $userIdentity, self::$storage);
    }

    public function takeByIdentity(string $identity): User
    {
        return self::$storage[$identity] ?? throw new UserNotFoundException();
    }
}
