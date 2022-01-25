<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ACL\Identity;

use Cardz\Generic\Identity\Application\Commands\ClearTokens;
use Cardz\Generic\Identity\Application\Commands\RegisterUser;
use Cardz\Generic\Identity\Application\Queries\GetToken;
use Cardz\Support\MobileAppGateway\Integration\Contracts\IdentityContextInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Queries\QueryBusInterface;

class MonolithIdentityAdapter implements IdentityContextInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function registerUser(?string $email, ?string $phone, string $name, string $password): string
    {
        $command = RegisterUser::of($name, $password, $email, $phone);
        $this->commandBus->dispatch($command);
        return $command->getUserId();
    }

    public function getToken(string $identity, string $password, string $deviceName): string
    {
        $query = GetToken::of($identity, $password, $deviceName);
        return $this->queryBus->execute($query);
    }

    public function clearTokens(string $userId): string
    {
        $command = ClearTokens::of($userId, false);
        $this->commandBus->dispatch($command);
        return $command->getUserId();
    }
}
