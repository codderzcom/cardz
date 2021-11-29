<?php

namespace App\Shared\Infrastructure\CommandHandling;

use App\Shared\Contracts\Commands\CommandHandlerInterface;
use App\Shared\Contracts\Commands\CommandHandlerProviderInterface;
use App\Shared\Contracts\Commands\CommandInterface;
use Closure;
use phpDocumentor\Reflection\Types\Callable_;
use ReflectionClass;
use ReflectionMethod;

class DeferredHandlerGenerator implements CommandHandlerProviderInterface
{
    /**
     * @var CommandHandlerInterface[]
     */
    protected array $handlers = [];

    /**
     * @var callable
     */
    protected $maker;

    /** @var array string[] */
    protected array $handlerContainerClasses;

    protected bool $registered = false;

    public function __construct(callable $maker)
    {
        $this->maker = $maker;
    }

    public static function of(callable $maker): static
    {
        return new static($maker);
    }

    public function parse(string ...$handlerContainerClasses): static
    {
        $this->handlerContainerClasses = $handlerContainerClasses;
        $this->registered = false;
        return $this;
    }

    public function getHandlers(): array
    {
        if (!$this->registered) {
            $this->registerHandlerContainers();
        }
        return $this->handlers;
    }

    protected function registerHandlerContainers(): void
    {
        foreach ($this->handlerContainerClasses as $handlerContainerClass) {
            $this->registerHandlerContainer($handlerContainerClass);
        }
        $this->registered = true;
    }

    protected function registerHandlerContainer(string $handlerContainerClass): void
    {
        $reflection = new ReflectionClass($handlerContainerClass);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $this->registerMethod($handlerContainerClass, $method);
        }
    }

    protected function registerMethod(string $handlerContainerClass, ReflectionMethod $method): void
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
        $this->handlers[] = $this->makeHandlerFor($parameterClass->name, $method->name, $handlerContainerClass);
    }

    protected function makeHandlerFor(string $for, string $handlingMethod, string $origin): CommandHandlerInterface
    {
        return
            new class($handlingMethod, $for, $origin, $this->maker) implements CommandHandlerInterface {
                private $originMaker;
                public function __construct(
                    private string $method,
                    private string $handles,
                    private string $origin,
                    callable $originMaker,
                ) {
                    $this->originMaker = $originMaker;
                }

                public function handles(CommandInterface $command): bool
                {
                    return $command instanceof $this->handles;
                }

                public function handle(CommandInterface $command): void
                {
                    [call_user_func($this->originMaker, $this->origin), $this->method]($command);
                }
            };
    }
}
