<?php

namespace App\Contexts\Workspaces\Domain\Model\Shared;

use App\Contexts\Workspaces\Domain\Persistable;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use function json_try_encode;

abstract class Entity implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
