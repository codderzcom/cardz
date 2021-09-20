<?php

namespace App\Contexts\Workspaces\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class WorkspaceProfileFilled extends BaseIntegrationEvent
{
    protected string $in = 'Workspaces';

    protected string $of = 'Workspace';
}
