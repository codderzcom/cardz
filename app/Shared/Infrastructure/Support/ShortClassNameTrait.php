<?php

namespace App\Shared\Infrastructure\Support;

trait ShortClassNameTrait
{
    public static function shortName(): string
    {
        return substr(strrchr('\\' . static::class, '\\'), 1);
    }
}
