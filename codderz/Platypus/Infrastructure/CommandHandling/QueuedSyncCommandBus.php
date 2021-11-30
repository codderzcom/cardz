<?php

namespace Codderz\Platypus\Infrastructure\CommandHandling;

use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Commands\CommandHandlerInterface;
use Codderz\Platypus\Contracts\Commands\CommandHandlerProviderInterface;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

class QueuedSyncCommandBus implements CommandBusInterface
{
    protected const FAILSAFE = 100;

    protected array $registeredHandlers = [];

    protected array $commandQueue = [];

    protected bool $running = false;

    public function dispatch(CommandInterface $command): void
    {
        $this->commandQueue[] = $command;
        $this->run();
    }

    public function registerProvider(CommandHandlerProviderInterface $provider): void
    {
        $this->registerHandlers(...$provider->getHandlers());
    }

    public function registerHandlers(CommandHandlerInterface ...$handlers): void
    {
        $this->registeredHandlers = array_merge($this->registeredHandlers, $handlers);
    }

    protected function run(): void
    {
        if ($this->running) {
            return;
        }

        $this->running = true;
        try {
            for ($index = 0; $index < $this::FAILSAFE && count($this->commandQueue) > 0; $index++) {
                $command = array_shift($this->commandQueue);
                $this->handleCommand($command);
            }
        } finally {
            $this->running = false;
        }
    }

    protected function handleCommand(CommandInterface $command): void
    {
        /** @var CommandHandlerInterface $handler */
        foreach ($this->registeredHandlers as $handler) {
            if ($handler->handles($command)) {
                $handler->handle($command);
                break;
            }
        }
    }

}
