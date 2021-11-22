<?php

namespace App\Contexts\Identity\Tests\Support\Mocks;

use App\Contexts\Identity\Domain\Model\User\User;
use App\Contexts\Identity\Domain\Model\User\UserIdentity;
use App\Contexts\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Shared\Exceptions\NotFoundException;

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
        return self::$storage[$identity] ?? throw new NotFoundException();
    }
}
