<?php

namespace App\Contexts\Workspaces\Domain\Model\Shared;

use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;
use App\Contexts\Workspaces\Domain\Persistable;
use function json_try_encode;

abstract class Entity implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
