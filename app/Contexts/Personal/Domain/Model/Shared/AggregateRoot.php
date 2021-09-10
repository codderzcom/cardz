<?php

namespace App\Contexts\Personal\Domain\Model\Shared;

use App\Contexts\Personal\Domain\Persistable;
use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;

abstract class AggregateRoot implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
