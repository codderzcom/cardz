<?php

namespace App\Shared\Infrastructure\QueryHandling;

use App\Shared\Contracts\Queries\QueryExecutorProviderInterface;

class LaravelExecutorGenerator implements QueryExecutorProviderInterface
{

    public function __construct(
        protected DeferredExecutorGenerator $deferredExecutorGenerator,
        protected array $executorContainerClasses,
    ) {
        $this->deferredExecutorGenerator->parse(...$this->executorContainerClasses);
    }

    public static function of(string ...$executorContainerClasses): static
    {
        return new static(DeferredExecutorGenerator::of(fn($makeable) => app()->make($makeable)), $executorContainerClasses);
    }

    public function getExecutors(): array
    {
        return $this->deferredExecutorGenerator->getExecutors();
    }

}
