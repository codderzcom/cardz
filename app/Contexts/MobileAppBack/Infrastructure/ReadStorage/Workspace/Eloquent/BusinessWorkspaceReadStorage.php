<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Models\Workspace as EloquentWorkspace;
use function json_try_decode;

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
}
