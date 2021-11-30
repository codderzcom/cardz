<?php

namespace Cardz\Core\Personal\Integration\Events;

use Cardz\Core\Personal\Domain\Model\Person\Person;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;

abstract class BaseIntegrationEvent implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    protected function __construct(
        protected Person $person,
    ) {
    }

    public static function of(Person $person): static
    {
        return new static($person);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->person->toArray(),
        ];
    }
}
