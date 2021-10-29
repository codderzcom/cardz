<?php

namespace App\Shared\Infrastructure\CommandHandling;

use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Commands\CommandHandlerInterface;
use App\Shared\Contracts\Commands\CommandHandlerProviderInterface;
use App\Shared\Contracts\Commands\CommandInterface;
use WeakMap;

class QueuedSyncCommandBus implements CommandBusInterface
{
    protected const FAILSAFE = 100;

    protected array $registeredHandlers = [];

    protected array $commandQueue = [];

    protected bool $running = false;

    protected WeakMap $results;

    public function __construct()
    {
        $this->results = new WeakMap();
    }

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

    public function getCommandResult(CommandInterface $command)
    {
        return $this->results[$command] ?? null;
    }

    protected function run(): void
    {
        if ($this->running) {
            return;
        }

        $this->running = true;
        for ($index = 0; $index < $this::FAILSAFE && count($this->commandQueue) > 0; $index++) {
            $command = array_shift($this->commandQueue);
            $this->handleCommand($command);
        }
        $this->running = false;
    }

    protected function handleCommand(CommandInterface $command): void
    {
        /** @var CommandHandlerInterface $handler */
        foreach ($this->registeredHandlers as $handler) {
            if ($handler->handles($command)) {
                $handler->handle($command);
                $this->results[$command] = $handler->getResult();
                break;
            }
        }
    }

}
