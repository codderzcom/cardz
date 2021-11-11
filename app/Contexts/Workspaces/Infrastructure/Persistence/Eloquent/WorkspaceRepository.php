<?php

namespace App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Exceptions\WorkspaceNotFoundException;
use App\Models\Workspace as EloquentWorkspace;
use App\Shared\Infrastructure\Support\PropertiesExtractorTrait;

class WorkspaceRepository implements WorkspaceRepositoryInterface
{
    use PropertiesExtractorTrait;

    public function persist(Workspace $workspace): void
    {
        EloquentWorkspace::query()->updateOrCreate(
            ['id' => $workspace->workspaceId],
            $this->workspaceAsData($workspace)
        );
    }

    public function take(WorkspaceId $workspaceId): Workspace
    {
        /** @var EloquentWorkspace $eloquentWorkspace */
        $eloquentWorkspace = EloquentWorkspace::query()->find((string) $workspaceId);
        if ($eloquentWorkspace === null) {
            throw new WorkspaceNotFoundException((string) $workspaceId);
        }
        return $this->workspaceFromData($eloquentWorkspace);
    }

    private function workspaceAsData(Workspace $workspace): array
    {
        return [
            'id' => (string) $workspace->workspaceId,
            'keeper_id' => (string) $workspace->keeperId,
            'added_at' => $this->extractProperty($workspace, 'added'),
            'profile' => $workspace->profile->toArray(),
        ];
    }

    private function workspaceFromData(EloquentWorkspace $eloquentWorkspace): Workspace
    {
        $profile = is_string($eloquentWorkspace->profile) ? json_try_decode($eloquentWorkspace->profile) : $eloquentWorkspace->profile;
        return Workspace::restore(
            $eloquentWorkspace->id,
            $eloquentWorkspace->keeper_id,
            $eloquentWorkspace->added_at,
            $profile,
        );
    }
}
