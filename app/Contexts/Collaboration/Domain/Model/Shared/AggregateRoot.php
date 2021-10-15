<?php

namespace App\Contexts\Collaboration\Domain\Model\Shared;

use App\Contexts\Collaboration\Domain\Persistable;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use function json_try_encode;

abstract class AggregateRoot implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
