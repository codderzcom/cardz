<?php

namespace App\Shared\Infrastructure\CommandHandling;

use App\Shared\Contracts\Commands\CommandHandlerInterface;
use App\Shared\Contracts\Commands\CommandHandlerProviderInterface;
use App\Shared\Contracts\Commands\CommandInterface;
use ReflectionClass;
use ReflectionMethod;

class SimpleAutoCommandClassHandlerProvider implements CommandHandlerProviderInterface
{
    /**
     * @var CommandHandlerInterface[]
     */
    protected array $handlers = [];

    public function __construct()
    {
    }

    public static function parse(string ...$handlerCollections): static
    {
        $provider = new static();
        foreach ($handlerCollections as $handlerCollection) {
            $provider->registerHandlerCollection($handlerCollection);
        }
        return $provider;
    }

    public function getHandlers(): array
    {
        return $this->handlers;
    }

    protected function registerHandlerCollection(string $handlerCollection): void
    {
        $reflection = new ReflectionClass($handlerCollection);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $this->registerMethod($handlerCollection, $method);
        }
    }

    protected function registerMethod(string $handlerCollection, ReflectionMethod $method): void
    {
        $parameters = $method->getParameters();
        if (count($parameters) !== 1) {
            return;
        }
        $parameter = $parameters[0];
        $parameterClass = $parameter->getType() && !$parameter->getType()->isBuiltin()
            ? new ReflectionClass($parameter->getType()->getName()) : null;
        if ($parameterClass === null || !$parameterClass->implementsInterface(CommandInterface::class)) {
            return;
        }
        $this->handlers[] = $this->makeHandlerFor($parameterClass->name, $method->name, $handlerCollection);
    }

    protected function makeHandlerFor(string $for, string $handlingMethod, string $origin): CommandHandlerInterface
    {
        $origin ??= $this;
        return
            new class($handlingMethod, $for, $origin) implements CommandHandlerInterface {
                public function __construct(
                    private string $method,
                    private string $handles,
                    private string $origin,
                ) {
                }

                public function handles(CommandInterface $command): bool
                {
                    return $command instanceof $this->handles;
                }

                public function handle(CommandInterface $command): void
                {
                    [app()->make($this->origin), $this->method]($command);
                }
            };
    }
}
