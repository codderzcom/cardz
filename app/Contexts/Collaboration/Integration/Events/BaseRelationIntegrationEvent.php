<?php

namespace App\Contexts\Collaboration\Integration\Events;

use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\Pure;

abstract class BaseRelationIntegrationEvent implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    protected function __construct(
        protected Relation $relation,
    ) {
    }

    #[Pure]
    public static function of(Relation $relation): static
    {
        return new static($relation);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->relation->toArray(),
        ];
    }
}
