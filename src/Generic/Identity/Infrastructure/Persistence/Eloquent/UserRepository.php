<?php

namespace Cardz\Generic\Identity\Infrastructure\Persistence\Eloquent;

use App\Models\User as EloquentUser;
use Carbon\Carbon;
use Cardz\Generic\Identity\Domain\Model\User\User;
use Cardz\Generic\Identity\Domain\Model\User\UserIdentity;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Infrastructure\Exceptions\UserNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;
use JetBrains\PhpStorm\ArrayShape;

class UserRepository implements UserRepositoryInterface
{
    use PropertiesExtractorTrait;

    public function persist(User $user): void
    {
        EloquentUser::query()->updateOrCreate(
            ['id' => (string) $user->userId],
            $this->userAsData($user)
        );
    }

    public function isExistingIdentity(UserIdentity $userIdentity): bool
    {
        $query = EloquentUser::query()->whereNull('id');
        if ($userIdentity->getEmail() !== null) {
            $query->orWhere('email', '=', $userIdentity->getEmail());
        }
        if ($userIdentity->getPhone() !== null) {
            $query->orWhere('phone', '=', $userIdentity->getPhone());
        }

        $eloquentUser = $query->first();
        return $eloquentUser !== null;
    }

    public function takeByIdentity(string $identity): User
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

    #[ArrayShape([
        'id' => "mixed",
        'email' => "mixed",
        'phone' => "mixed",
        'name' => "mixed",
        'password' => "string",
        'remember_token' => "bool",
        'registration_initiated_at' => Carbon::class | null,
        'email_verified_at' => Carbon::class | null,
    ])]
    private function userAsData(User $user): array
    {
        $properties = $this->extractProperties($user, 'registrationInitiated', 'emailVerified', 'password', 'rememberToken');
        $properties = array_merge($properties, $user->toArray());
        return [
            'id' => $properties['userId'],
            'email' => $properties['email'],
            'phone' => $properties['phone'],
            'name' => $properties['name'],
            'password' => (string) $properties['password'],
            'remember_token' => $properties['rememberToken'],
            'registration_initiated_at' => $properties['registrationInitiated'],
            'email_verified_at' => $properties['emailVerified'],
        ];
    }

    private function userFromData(EloquentUser $eloquentUser): User
    {
        return User::restore(
            $eloquentUser->id,
            $eloquentUser->email,
            $eloquentUser->phone,
            $eloquentUser->name,
            $eloquentUser->password,
            $eloquentUser->getRememberToken(),
            $eloquentUser->registration_initiated_at,
            $eloquentUser->email_verified_at,
        );
    }
}
