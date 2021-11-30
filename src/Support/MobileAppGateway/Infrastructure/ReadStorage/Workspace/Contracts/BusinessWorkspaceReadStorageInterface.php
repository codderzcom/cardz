<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessWorkspace;

interface BusinessWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): BusinessWorkspace;

    /**
     * @return BusinessWorkspace[]
     */
    public function allForCollaborator(string $collaboratorId): array;

}
