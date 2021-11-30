<?php

namespace Cardz\Generic\Identity\Integration\Events;

use Cardz\Generic\Identity\Domain\Model\User\User;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class RegistrationCompleted implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    private function __construct(
        protected User $user,
    ) {
    }

    #[Pure]
    public static function of(User $user): self
    {
        return new self($user);
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'payload' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->user->toArray(),
        ];
    }
}
