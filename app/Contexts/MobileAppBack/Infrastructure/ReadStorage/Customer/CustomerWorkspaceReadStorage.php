<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer;

use App\Contexts\MobileAppBack\Application\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Domain\ReadModel\Customer\CustomerWorkspace;
use App\Models\Workspace as EloquentWorkspace;

class CustomerWorkspaceReadStorage implements CustomerWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?CustomerWorkspace
    {
        /** @var EloquentWorkspace $workspace */
        $workspace = EloquentWorkspace::query()->find($workspaceId);
        if ($workspace === null) {
            return null;
        }

        return $this->workspaceFromEloquent($workspace);
    }

    /**
     * @return CustomerWorkspace[]
     */
    public function all(): array
    {
        $workspaces = EloquentWorkspace::all();
        $customerWorkspaces = [];
        foreach ($workspaces as $workspace) {
            $customerWorkspaces[] = $this->workspaceFromEloquent($workspace);
        }

        return $customerWorkspaces;
    }

    private function workspaceFromEloquent(EloquentWorkspace $workspace): CustomerWorkspace
    {
        $profile = is_string($workspace->profile) ? json_try_decode($workspace->profile) : $workspace->profile;

        return CustomerWorkspace::make(
            $workspace->id,
            $profile['name'] ?? '',
            $profile['description'] ?? '',
            $profile['address'] ?? '',
        );
    }
}
