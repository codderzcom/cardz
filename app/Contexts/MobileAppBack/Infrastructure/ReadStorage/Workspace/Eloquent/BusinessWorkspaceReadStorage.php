<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Contexts\MobileAppBack\Infrastructure\Exceptions\BusinessWorkspaceNotFoundException;
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

    public function allForCollaborator(string $collaboratorId): array
    {
        $workspaces = EloquentWorkspace::query()->fromQuery("
            select w.* from workspaces w
            inner join relations r on w.id = r.workspace_id
                where w.keeper_id = :collaborator_id
                or r.collaborator_id = :collaborator_id;
        ", ['collaborator_id' => $collaboratorId]);
        $businessWorkspaces = [];
        foreach ($workspaces as $workspace) {
            $businessWorkspaces[] = $this->workspaceFromEloquent($workspace);
        }
        return $businessWorkspaces;
    }

    public function forKeeper(string $keeperId, string $workspaceId): BusinessWorkspace
    {
        /** @var EloquentWorkspace $workspace */
        $workspace = EloquentWorkspace::query()
            ->where('id', '=', $workspaceId)
            ->where('keeper_id', '=', $keeperId)
            ->first();

        return $workspace !== null ? $this->workspaceFromEloquent($workspace) : throw new BusinessWorkspaceNotFoundException();
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
