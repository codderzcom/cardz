<?php

namespace App\Contexts\Plans\Domain\Model\Achievement;

use Ramsey\Uuid\Guid\Guid;

class AchievementId
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
