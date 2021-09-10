<?php

namespace App\Contexts\Personal\Domain\Model\Shared;

use App\Contexts\Personal\Domain\Persistable;
use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;
use function json_try_encode;

abstract class Entity implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
