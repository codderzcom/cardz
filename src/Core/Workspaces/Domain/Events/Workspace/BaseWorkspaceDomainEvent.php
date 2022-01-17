<?php

namespace Cardz\Core\Workspaces\Domain\Events\Workspace;

use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateEventTrait;

abstract class BaseWorkspaceDomainEvent implements AggregateEventInterface
{
    use AggregateEventTrait;

    protected int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

}
