<?php

namespace App\Contexts\Plans\Integration\Events;

use App\Contexts\Plans\Domain\ReadModel\ReadPlan;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

abstract class BasePlanIntegrationEvent implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    protected function __construct(
        protected ReadPlan $plan,
    ) {
    }

    #[Pure]
    public static function of(ReadPlan $plan): static
    {
        return new static($plan);
    }

    #[ArrayShape(['name' => "string", 'payload' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->plan->toArray(),
        ];
    }
}
