<?php

namespace Codderz\Platypus\Infrastructure\QueryHandling;

use Codderz\Platypus\Contracts\Queries\QueryExecutorProviderInterface;
use Codderz\Platypus\Contracts\Queries\QueryInterface;
use Codderz\Platypus\Exceptions\QueryHandlingException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class SimpleAutoQueryExecutorProvider implements QueryExecutorProviderInterface
{
    protected array $executors = [];

    public function __construct()
    {
    }

    public static function parse(object ...$executorCollections): static
    {
        $provider = new static();
        foreach ($executorCollections as $executorCollection) {
            try {
                $provider->registerExecutorCollection($executorCollection);
            } catch (ReflectionException $exception) {
                throw new QueryHandlingException('Unable to register executor container. ' . $exception->getMessage());
            }
        }
        return $provider;
    }

    public function getExecutors(): array
    {
        return $this->executors;
    }

    /**
     * @throws ReflectionException
     */
    protected function registerExecutorCollection(object $executorCollection): void
    {
        $reflection = new ReflectionClass($executorCollection);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $this->registerMethod($executorCollection, $method);
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function registerMethod(object $executorCollection, ReflectionMethod $method): void
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
        $this->executors[$parameterClass->name] = [$executorCollection, $method->name];
    }
}
