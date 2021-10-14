<?php

namespace App\Contexts\Auth\Infrastructure\Persistence\Eloquent;

use App\Contexts\Auth\Application\Exceptions\UserNotFoundException;
use App\Contexts\Auth\Domain\Model\User\User;
use App\Contexts\Auth\Domain\Model\User\UserId;
use App\Contexts\Auth\Domain\Model\User\UserIdentity;
use App\Contexts\Auth\Infrastructure\Persistence\Contracts\UserRepositoryInterface;
use App\Models\User as EloquentUser;
use ReflectionClass;

class UserRepository implements UserRepositoryInterface
{
    public function persist(User $user): void
    {
        EloquentUser::query()->updateOrCreate(
            ['id' => (string) $user->userId],
            $this->userAsData($user)
        );
    }

    public function take(UserId $userId = null): User
    {
        /** @var EloquentUser $eloquentUser */
        $eloquentUser = EloquentUser::query()->find((string) $userId);
        if ($eloquentUser === null) {
            throw new UserNotFoundException((string) $userId);
        }
        return $this->userFromData($eloquentUser);
    }

    public function isExistingIdentity(UserIdentity $userIdentity): bool
    {
        $query = EloquentUser::query();
        if ($userIdentity->getEmail() !== null) {
            $query->where('email', '=', $userIdentity->getEmail());
        }
        if ($userIdentity->getPhone() !== null) {
            $query->where('phone', '=', $userIdentity->getPhone());
        }

        $eloquentUser = $query->first();
        return $eloquentUser !== null;
    }

    public function takeWithAmbiguousIdentity(string $identity): User
    {
        /** @var EloquentUser $eloquentUser */
        $eloquentUser = EloquentUser::query()
            ->where('email', '=', $identity)
            ->orWhere('phone', '=', $identity)
            ->first();
        if (!$eloquentUser) {
            throw new UserNotFoundException("User $identity not found");
        }
        return $this->userFromData($eloquentUser);
    }

    private function userAsData(User $user): array
    {
        $reflection = new ReflectionClass($user);
        $properties = [
            'registrationInitiated' => null,
            'emailVerified' => null,
            'password' => null,
            'rememberToken' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($user);
        }
        $properties = array_merge($properties, $user->toArray());

        $data = [
            'id' => $properties['userId'],
            'email' => $properties['email'],
            'phone' => $properties['phone'],
            'name' => $properties['name'],
            'password' => (string) $properties['password'],
            'remember_token' => $properties['rememberToken'],
            'registration_initiated_at' => $properties['registrationInitiated'],
            'email_verified_at' => $properties['emailVerified'],
        ];

        return $data;
    }

    private function userFromData(EloquentUser $eloquentUser): User
    {
        $user = User::restore(
            $eloquentUser->id,
            $eloquentUser->email,
            $eloquentUser->phone,
            $eloquentUser->name,
            $eloquentUser->password,
            $eloquentUser->getRememberToken(),
            $eloquentUser->registration_initiated_at,
            $eloquentUser->email_verified_at,
        );
        return $user;
    }
}
