<?php

namespace App\Contexts\Workspaces\Domain\Events\Workspace;

use App\Contexts\Plans\Domain\Events\BaseDomainEvent;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;

abstract class BaseWorkspaceDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public WorkspaceId $workspaceId
    ) {
        parent::__construct();
    }
}
