<?php

namespace Codderz\Platypus\Contracts\Commands;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;

    public function registerHandlers(CommandHandlerInterface ...$handlers): void;

    public function registerProvider(CommandHandlerProviderInterface $provider): void;
}
