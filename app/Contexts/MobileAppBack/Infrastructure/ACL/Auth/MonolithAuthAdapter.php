<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Auth;

use App\Contexts\Auth\Application\Commands\IssueToken;
use App\Contexts\Auth\Application\Commands\RegisterUser;
use App\Contexts\MobileAppBack\Integration\Contracts\AuthContextInterface;
use App\Shared\Contracts\Commands\CommandBusInterface;

class MonolithAuthAdapter implements AuthContextInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function registerUser(?string $email, ?string $phone, string $name, string $password, string $deviceName): string
    {
        $command = RegisterUser::of($name, $password, $email, $phone);
        $this->commandBus->dispatch($command);

        $this->issueToken($email ?: $phone, $password, $deviceName);
    }

    public function issueToken(string $identity, string $password, string $deviceName): string
    {
        $command = IssueToken::of($identity, $password, $deviceName);
        $this->commandBus->dispatch($command);
        return $this->commandBus->getCommandResult($command);
    }

}
