<?php

namespace Codderz\Platypus\Infrastructure\Messaging;

use Codderz\Platypus\Infrastructure\Support\ShortClassNameTrait;
use JetBrains\PhpStorm\Pure;

trait IntegrationEventTrait
{
    use ShortClassNameTrait;

    #[Pure]
    public function __toString()
    {
        return $this::shortName();
    }

    public function getName(): string
    {
        return $this::class;
    }

}
