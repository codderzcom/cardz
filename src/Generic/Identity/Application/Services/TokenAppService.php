<?php

namespace Cardz\Generic\Identity\Application\Services;

use App\Models\User as EloquentUser;
use Cardz\Generic\Identity\Application\Commands\ClearTokens;
use Cardz\Generic\Identity\Application\Queries\GetToken;
use Cardz\Generic\Identity\Domain\Exceptions\UserNotFoundExceptionInterface;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Infrastructure\Exceptions\UserNotFoundException;
use Cardz\Generic\Identity\Infrastructure\Messaging\DomainEventBusInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

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

    public function clearTokens(ClearTokens $command): void
    {
        $command->exceptLast()
            ? $this->clearOldTokens($command->getUserId())
            : $this->clearAllTokens($command->getUserId());
    }

    private function clearAllTokens(string $userId): void
    {
        /** @var Model $tokenModel */
        $tokenModel = Sanctum::$personalAccessTokenModel;
        $tokenModel::query()
            ->where('tokenable_id', '=', $userId)
            ->delete();
    }

    private function clearOldTokens(string $userId): void
    {
        /** @var Model $tokenModel */
        $tokenModel = Sanctum::$personalAccessTokenModel;

        $eloquentToken = $tokenModel::query()->where('tokenable_id', '=', $userId)->latest()->first();
        if ($eloquentToken === null) {
            return;
        }

        $tokenModel::query()
            ->where('tokenable_id', '=', $userId)
            ->where('name', '=', $eloquentToken->name)
            ->whereNotIn('id', [$eloquentToken->id])
            ->delete();
    }
}
