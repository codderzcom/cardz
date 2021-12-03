<?php

namespace Codderz\Platypus\Infrastructure\Messaging;

use Codderz\Platypus\Infrastructure\Support\ShortClassNameTrait;

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
