<?php

namespace Cardz\Core\Workspaces\Domain\Events\Workspace;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseWorkspaceDomainEvent extends DomainEvent
{
    public function with(): Workspace
    {
        return $this->aggregateRoot;
    }
}
