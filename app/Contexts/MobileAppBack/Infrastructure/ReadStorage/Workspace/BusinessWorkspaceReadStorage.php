<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Models\Workspace as EloquentWorkspace;

class BusinessWorkspaceReadStorage implements BusinessWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?BusinessWorkspace
    {
        /** @var EloquentWorkspace $workspace */
        $workspace = EloquentWorkspace::query()->find($workspaceId);
        if ($workspace === null) {
            return null;
        }

        return $this->workspaceFromEloquent($workspace);
    }

    /**
     * @return BusinessWorkspace[]
     */
    public function allForKeeper(string $keeperId): array
    {
        $workspaces = EloquentWorkspace::query()
            ->where('keeper_id', '=', $keeperId)
            ->get();
        $customerWorkspaces = [];
        foreach ($workspaces as $workspace) {
            $customerWorkspaces[] = $this->workspaceFromEloquent($workspace);
        }

        return $customerWorkspaces;
    }

    private function workspaceFromEloquent(EloquentWorkspace $workspace): BusinessWorkspace
    {
        $profile = is_string($workspace->profile) ? json_try_decode($workspace->profile) : $workspace->profile;

        return BusinessWorkspace::make(
            $workspace->id,
            $workspace->keeper_id,
            $profile['name'] ?? '',
            $profile['description'] ?? '',
            $profile['address'] ?? '',
        );
    }
}
