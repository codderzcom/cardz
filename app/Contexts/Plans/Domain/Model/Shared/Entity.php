<?php

namespace App\Contexts\Plans\Domain\Model\Shared;

use App\Contexts\Plans\Domain\Persistable;
use function json_try_encode;

abstract class Entity implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
