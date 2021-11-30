<?php

namespace Cardz\Support\Collaboration\Integration\Events;

use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;
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
