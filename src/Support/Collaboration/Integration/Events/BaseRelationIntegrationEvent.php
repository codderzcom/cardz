<?php

namespace Cardz\Support\Collaboration\Integration\Events;

use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\ArrayShape;
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

    #[ArrayShape(['name' => "string", 'payload' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->relation->toArray(),
        ];
    }
}
