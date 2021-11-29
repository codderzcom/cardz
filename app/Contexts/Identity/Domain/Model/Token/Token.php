<?php

namespace App\Contexts\Identity\Domain\Model\Token;

use App\Contexts\Identity\Domain\Events\Token\TokenAssigned;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;

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
