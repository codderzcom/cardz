<?php

namespace Cardz\Core\Plans\Integration\Events;

use Cardz\Core\Plans\Domain\ReadModel\ReadPlan;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;
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
