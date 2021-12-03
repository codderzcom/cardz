<?php

namespace Codderz\Platypus\Infrastructure\CommandHandling;

use Codderz\Platypus\Contracts\Commands\CommandHandlerInterface;
use Codderz\Platypus\Contracts\Commands\CommandHandlerProviderInterface;
use Codderz\Platypus\Contracts\Commands\CommandInterface;
use ReflectionClass;
use ReflectionMethod;

class SimpleAutoCommandHandlerProvider implements CommandHandlerProviderInterface
{
    /**
     * @var CommandHandlerInterface[]
     */
    protected array $handlers = [];

    public function __construct()
    {
    }

    public static function parse(object ...$handlerCollections): static
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

    protected function registerHandlerCollection(object $handlerCollection): void
    {
        $reflection = new ReflectionClass($handlerCollection);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $this->registerMethod($handlerCollection, $method);
        }
    }

    protected function registerMethod(object $handlerCollection, ReflectionMethod $method): void
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

    protected function makeHandlerFor(string $for, string $handlingMethod, ?object $origin = null): CommandHandlerInterface
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
