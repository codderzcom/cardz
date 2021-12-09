<?php

namespace Cardz\Core\Workspaces\Domain\Events\Workspace;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateEventTrait;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

/**
 * @method Workspace with()
 */
abstract class BaseWorkspaceDomainEvent implements AggregateEventInterface
{
    use AggregateEventTrait;

    protected int $version = 1;

    public function version(): int
    {
        return $this->version;
    }

}
