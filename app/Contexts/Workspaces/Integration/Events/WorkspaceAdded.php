<?php

namespace App\Contexts\Workspaces\Integration\Events;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class WorkspaceAdded extends BaseIntegrationEvent
{
    protected string $in = 'Workspaces';

    protected string $of = 'Workspace';
}
