<?php

namespace App\Contexts\Workspaces\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class WorkspaceAdded extends BaseIntegrationEvent
{
    protected ?string $instanceOf = 'Workspace';
}
