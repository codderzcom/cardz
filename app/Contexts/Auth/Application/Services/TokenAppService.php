<?php

namespace App\Contexts\Auth\Application\Services;

use App\Contexts\Auth\Application\Commands\IssueTokenCommandInterface;
use App\Contexts\Auth\Application\Exceptions\UserNotFoundException;
use App\Contexts\Auth\Domain\Model\Token\Token;
use App\Contexts\Auth\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Auth\Infrastructure\Persistence\Contracts\UserRepositoryInterface;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;

class TokenAppService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function issueToken(IssueTokenCommandInterface $command): Token
    {
        $user = $this->userRepository->takeWithAmbiguousIdentity($command->getIdentity());

        if (!Hash::check($command->getPassword(), $user->getPasswordHash())) {
            throw new UserNotFoundException("Invalid credentials");
        }

        //ToDo: перенести в свой код?
        /** @var EloquentUser $eloquentUser */
        $eloquentUser = EloquentUser::query()->find($user->userId);
        $plainTextToken = $eloquentUser->createToken($command->getDeviceName())->plainTextToken;
        $token = $user->assignToken($plainTextToken);
        $this->domainEventBus->publish(...$token->releaseEvents());
        return $token;
    }
}
