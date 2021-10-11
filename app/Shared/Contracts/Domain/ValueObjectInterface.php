<?php

namespace App\Shared\Contracts\Domain;

interface ValueObjectInterface
{
    public function toArray(): array;
}
