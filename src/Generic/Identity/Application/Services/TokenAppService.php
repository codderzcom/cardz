<?php

namespace Cardz\Generic\Identity\Application\Services;

use App\Models\User as EloquentUser;
use Cardz\Generic\Identity\Application\Queries\GetToken;
use Cardz\Generic\Identity\Domain\Exceptions\UserNotFoundExceptionInterface;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Infrastructure\Exceptions\UserNotFoundException;
use Cardz\Generic\Identity\Infrastructure\Messaging\DomainEventBusInterface;
use Illuminate\Support\Facades\Hash;

class TokenAppService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    /**
     * @throws UserNotFoundExceptionInterface
     */
    public function issueToken(GetToken $query): string
    {
        $user = $this->userRepository->takeByIdentity($query->getIdentity());

        if (!Hash::check($query->getPassword(), $user->getPasswordHash())) {
            throw new UserNotFoundException("Invalid credentials");
        }

        //ToDo: make own createToken?
        /** @var EloquentUser $eloquentUser */
        $eloquentUser = EloquentUser::query()->find($user->userId);
        $plainTextToken = $eloquentUser->createToken($query->getDeviceName())->plainTextToken;
        $token = $user->assignToken($plainTextToken);
        $this->domainEventBus->publish(...$token->releaseEvents());
        return $token->token;
    }
}
