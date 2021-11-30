<?php

namespace Cardz\Generic\Identity\Integration\Events;

use Cardz\Generic\Identity\Domain\Model\Token\Token;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;
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
