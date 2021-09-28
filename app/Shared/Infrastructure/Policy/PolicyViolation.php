<?php

namespace App\Shared\Infrastructure\Policy;

use App\Shared\Contracts\PolicyViolationInterface;
use JetBrains\PhpStorm\Pure;

class PolicyViolation implements PolicyViolationInterface
{
    protected function __construct(protected string $violation)
    {
    }

    #[Pure]
    public static function of(string $violation): static
    {
        return new static($violation);
    }

    public function __toString()
    {
        return $this->violation;
    }

}
