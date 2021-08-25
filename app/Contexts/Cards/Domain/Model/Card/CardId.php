<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use Ramsey\Uuid\Guid\Guid;

class CardId
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
