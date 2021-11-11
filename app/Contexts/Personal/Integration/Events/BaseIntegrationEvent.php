<?php

namespace App\Contexts\Personal\Integration\Events;

use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;

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
