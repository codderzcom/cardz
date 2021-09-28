<?php

namespace App\Contexts\Cards\Domain\Model\Shared;

use App\Contexts\Cards\Domain\Persistable;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
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
