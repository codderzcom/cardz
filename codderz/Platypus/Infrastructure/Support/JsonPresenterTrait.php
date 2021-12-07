<?php

namespace Codderz\Platypus\Infrastructure\Support;

use Carbon\Carbon;
use ReflectionClass;
use Stringable;

trait JsonPresenterTrait
{
    use ArrayPresenterTrait;

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
