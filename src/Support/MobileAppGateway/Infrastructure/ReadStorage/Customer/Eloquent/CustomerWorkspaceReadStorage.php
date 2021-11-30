<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Eloquent;

use App\Models\Workspace as EloquentWorkspace;
use Cardz\Support\MobileAppGateway\Domain\ReadModel\Customer\CustomerWorkspace;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use function json_try_decode;

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
}
