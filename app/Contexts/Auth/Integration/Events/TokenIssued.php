<?php

namespace App\Contexts\Auth\Integration\Events;

use App\Contexts\Auth\Domain\Model\Token\Token;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class TokenIssued implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    private function __construct(
        protected Token $token,
    ) {
    }

    #[Pure]
    public static function of(Token $token): self
    {
        return new self($token);
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'payload' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->token->toArray(),
        ];
    }
}
