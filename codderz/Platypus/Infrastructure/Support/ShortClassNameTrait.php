<?php

namespace Codderz\Platypus\Infrastructure\Support;

trait ShortClassNameTrait
{
    public static function shortName(): string
    {
        return substr(strrchr('\\' . static::class, '\\'), 1);
    }
}
