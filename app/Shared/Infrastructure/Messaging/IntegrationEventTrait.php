<?php

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Infrastructure\Support\ShortClassNameTrait;

trait IntegrationEventTrait
{
    use ShortClassNameTrait;

    public function __toString()
    {
        return $this::shortName();
    }

    public function getName(): string
    {
        return $this::class;
    }

}
