<?php

namespace App\Shared\Infrastructure\CommandHandling;

use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Commands\CommandHandlerInterface;
use App\Shared\Contracts\Commands\CommandInterface;

class CommandBus implements CommandBusInterface
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

    public function registerHandlers(CommandHandlerInterface ...$handlers): void
    {
        $this->registeredHandlers = array_merge($this->registeredHandlers, $handlers);
    }

}
