<?php

namespace App\Contexts\Collaboration\Integration\Events;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\Pure;

abstract class BaseInviteIntegrationEvent implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    protected function __construct(
        protected Invite $invite,
    ) {
    }

    #[Pure]
    public static function of(Invite $invite): static
    {
        return new static($invite);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->invite->toArray(),
        ];
    }
}
