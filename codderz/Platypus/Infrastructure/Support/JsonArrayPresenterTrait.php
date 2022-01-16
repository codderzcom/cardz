<?php

namespace Codderz\Platypus\Infrastructure\Support;

trait JsonArrayPresenterTrait
{
    use ArrayPresenterTrait;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
