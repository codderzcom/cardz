<?php

namespace App\Contexts\Workspaces\Domain\Model\Shared;

use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;
use App\Contexts\Workspaces\Domain\Persistable;
use JetBrains\PhpStorm\Immutable;
use function json_try_encode;

#[Immutable]
abstract class ValueObject implements Persistable
{
    use ArrayPresenterTrait;

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
