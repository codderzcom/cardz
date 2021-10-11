<?php

namespace App\Contexts\Cards\Integration\Events;

use App\Contexts\Cards\Domain\ReadModel\IssuedCard;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

abstract class BaseCardIntegrationEvent implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    protected function __construct(
        protected IssuedCard $card,
    ) {
    }

    #[Pure]
    public static function of(IssuedCard $card): static
    {
        return new static($card);
    }

    #[ArrayShape(['name' => "string", 'payload' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->card->toArray(),
        ];
    }
}
