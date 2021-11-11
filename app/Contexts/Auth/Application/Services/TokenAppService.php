<?php

namespace App\Contexts\Auth\Application\Services;

use App\Contexts\Auth\Application\Queries\GetToken;
use App\Contexts\Auth\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Auth\Infrastructure\Exceptions\UserNotFoundException;
use App\Contexts\Auth\Infrastructure\Messaging\DomainEventBusInterface;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;

class TokenAppService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function issueToken(GetToken $query): string
    {
        $user = $this->userRepository->takeByIdentity($query->getIdentity());

        if (!Hash::check($query->getPassword(), $user->getPasswordHash())) {
            throw new UserNotFoundException("Invalid credentials");
        }

        //ToDo: перенести в свой код?
        /** @var EloquentUser $eloquentUser */
        $eloquentUser = EloquentUser::query()->find($user->userId);
        $plainTextToken = $eloquentUser->createToken($query->getDeviceName())->plainTextToken;
        $token = $user->assignToken($plainTextToken);
        $this->domainEventBus->publish(...$token->releaseEvents());
        return $token->token;
    }
}
