<?php

namespace App\Shared\Infrastructure\Tests;

use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Commands\CommandHandlerInterface;
use App\Shared\Contracts\Commands\CommandHandlerProviderInterface;
use App\Shared\Contracts\Commands\CommandInterface;

class TestCommandBus implements CommandBusInterface
{
    protected array $registeredHandlers = [];

    public function dispatch(CommandInterface $command): void
    {
        /** @var CommandHandlerInterface $handler */
        foreach ($this->registeredHandlers as $handler) {
            if ($handler->handles($command)) {
                $handler->handle($command);
                break;
            }
        }
    }

    public function registerProvider(CommandHandlerProviderInterface $provider): void
    {
        $this->registerHandlers(...$provider->getHandlers());
    }

    public function registerHandlers(CommandHandlerInterface ...$handlers): void
    {
        $this->registeredHandlers = array_merge($this->registeredHandlers, $handlers);
    }
}
