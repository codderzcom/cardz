<?php

namespace App\Shared\Infrastructure\CommandHandling;

use App\Shared\Contracts\Commands\CommandHandlerInterface;
use App\Shared\Contracts\Commands\CommandHandlerProviderInterface;
use App\Shared\Contracts\Commands\CommandInterface;
use ReflectionClass;
use ReflectionMethod;

class SimpleAutoCommandHandlerProvider implements CommandHandlerProviderInterface
{
    use CommandHandlerFactoryTrait;

    /**
     * @var CommandHandlerInterface[]
     */
    protected array $handlers = [];

    public function __construct()
    {
    }

    public static function parse(object $handlerCollection): static
    {
        $provider = new static();
        $reflection = new ReflectionClass($handlerCollection);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $provider->registerMethod($handlerCollection, $method);
        }
        return $provider;
    }

    public function getHandlers(): array
    {
        return $this->handlers;
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

}
