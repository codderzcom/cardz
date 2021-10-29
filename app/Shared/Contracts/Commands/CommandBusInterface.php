<?php

namespace App\Shared\Contracts\Commands;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;

    public function registerHandlers(CommandHandlerInterface ...$handlers): void;

    public function registerProvider(CommandHandlerProviderInterface $provider): void;

    public function getCommandResult(CommandInterface $command);
}
