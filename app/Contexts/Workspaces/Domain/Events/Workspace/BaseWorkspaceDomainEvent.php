<?php

namespace App\Contexts\Workspaces\Domain\Events\Workspace;

use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseWorkspaceDomainEvent extends DomainEvent
{
    public function with(): Workspace
    {
        return $this->aggregateRoot;
    }
}
