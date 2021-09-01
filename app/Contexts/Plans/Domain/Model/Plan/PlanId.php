<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use Ramsey\Uuid\Guid\Guid;

final class PlanId
{
    public function __construct(private ?string $id = null)
    {
        if ($this->id === null) {
            $this->id = (string) Guid::uuid4();
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
