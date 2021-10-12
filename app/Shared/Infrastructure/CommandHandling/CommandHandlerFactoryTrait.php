<?php

namespace App\Shared\Infrastructure\CommandHandling;

use App\Shared\Contracts\Commands\CommandHandlerInterface;
use App\Shared\Contracts\Commands\CommandInterface;

trait CommandHandlerFactoryTrait
{
    public function makeHandlerFor(string $for, string $handlingMethod, ?object $origin = null): CommandHandlerInterface
    {
        $origin ??= $this;
        return
            new class($handlingMethod, $for, $origin) implements CommandHandlerInterface {

                public function __construct(
                    private string $method,
                    private string $handles,
                    private object $origin,
                ) {
                }

                public function handles(CommandInterface $command): bool
                {
                    return $command instanceof $this->handles;
                }

                public function handle(CommandInterface $command): void
                {
                    [$this->origin, $this->method]($command);
                }
            };
    }
}
