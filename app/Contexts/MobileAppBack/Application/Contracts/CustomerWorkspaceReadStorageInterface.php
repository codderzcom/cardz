<?php

namespace App\Contexts\MobileAppBack\Application\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\Customer\CustomerWorkspace;

interface CustomerWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?CustomerWorkspace;

    /**
     * @return CustomerWorkspace[]
     */
    public function all(): array;

}
