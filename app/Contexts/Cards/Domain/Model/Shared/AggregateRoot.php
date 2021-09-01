<?php

namespace App\Contexts\Cards\Domain\Model\Shared;

use App\Contexts\Cards\Domain\Persistable;

abstract class AggregateRoot implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
