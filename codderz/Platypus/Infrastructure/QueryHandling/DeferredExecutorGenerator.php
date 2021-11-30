<?php

namespace Codderz\Platypus\Infrastructure\QueryHandling;

use Closure;
use Codderz\Platypus\Contracts\Queries\QueryExecutorProviderInterface;
use Codderz\Platypus\Contracts\Queries\QueryInterface;
use ReflectionClass;
use ReflectionMethod;

class DeferredExecutorGenerator implements QueryExecutorProviderInterface
{
    /** @var callable[] */
    protected array $executors = [];

    /** @var callable */
    protected $maker;

    /** @var string[] */
    protected array $executorContainerClasses;

    protected bool $registered = false;

    public function __construct(callable $maker)
    {
        $this->maker = $maker;
    }

    public static function of(callable $maker): static
    {
        return new static($maker);
    }

    public function parse(string ...$executorContainerClasses): static
    {
        $this->executorContainerClasses = $executorContainerClasses;
        $this->registered = false;
        return $this;
    }

    public function getExecutors(): array
    {
        if (!$this->registered) {
            $this->registerExecutorContainers();
        }
        return $this->executors;
    }

    protected function registerExecutorContainers(): void
    {
        foreach ($this->executorContainerClasses as $executorContainerClass) {
            $this->registerExecutorContainer($executorContainerClass);
        }
        $this->registered = true;
    }

    protected function registerExecutorContainer(string $executorContainerClass): void
    {
        $reflection = new ReflectionClass($executorContainerClass);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $this->registerMethod($executorContainerClass, $method);
        }
    }

    protected function registerMethod(string $executorContainerClass, ReflectionMethod $method): void
    {
        $parameters = $method->getParameters();
        if (count($parameters) !== 1) {
            return;
        }
        $parameter = $parameters[0];
        $parameterClass = $parameter->getType() && !$parameter->getType()->isBuiltin()
            ? new ReflectionClass($parameter->getType()->getName()) : null;
        if ($parameterClass === null || !$parameterClass->implementsInterface(QueryInterface::class)) {
            return;
        }
        $this->executors[$parameterClass->name] = $this->makeExecutor($method->name, $executorContainerClass);
    }

    protected function makeExecutor(string $executingMethod, string $origin): Closure
    {
        return fn ($query) => [($this->maker)($origin), $executingMethod]($query);
    }
}
