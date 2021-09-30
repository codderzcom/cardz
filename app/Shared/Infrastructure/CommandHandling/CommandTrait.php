<?php

namespace App\Shared\Infrastructure\CommandHandling;

trait CommandTrait
{
    public function is(): string
    {
        return $this::class;
    }
}
