<?php

namespace Codderz\Platypus\Infrastructure\CommandHandling;

use Codderz\Platypus\Contracts\Commands\CommandHandlerProviderInterface;

class LaravelHandlerGenerator implements CommandHandlerProviderInterface
{

    public function __construct(
        protected DeferredHandlerGenerator $deferredHandlerGenerator,
        protected array $handlerContainerClasses,
    ) {
        $this->deferredHandlerGenerator->parse(...$this->handlerContainerClasses);
    }

    public static function of(string ...$handlerContainerClasses): static
    {
        return new static(DeferredHandlerGenerator::of(fn($makeable) => app()->make($makeable)), $handlerContainerClasses);
    }

    public function getHandlers(): array
    {
        return $this->deferredHandlerGenerator->getHandlers();
    }

}
