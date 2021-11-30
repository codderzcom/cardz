<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Customer\CustomerWorkspace;

interface CustomerWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?CustomerWorkspace;

    /**
     * @return CustomerWorkspace[]
     */
    public function all(): array;

}
