<?php

namespace Cardz\Generic\Identity\Domain\Model\Token;

use Cardz\Generic\Identity\Domain\Events\Token\TokenAssigned;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;

final class Token implements AggregateRootInterface
{
    use AggregateRootTrait;

    private function __construct(
        public string $userId,
        public string $token,
    ) {
    }

    public static function assign(string $userId, string $plainTextToken): self
    {
        $token = new self($userId, $plainTextToken);
        return $token->withEvents(TokenAssigned::of($token));
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'token' => $this->token,
        ];
    }
}
