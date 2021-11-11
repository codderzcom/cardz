<?php

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Contracts\Messaging\MessageChannelInterface;
use JetBrains\PhpStorm\Pure;

class SimpleMessageChannel implements MessageChannelInterface
{
    protected function __construct(
        protected string $name
    ) {
    }

    #[Pure]
    public static function of(string $name): static
    {
        return new static($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }

}
