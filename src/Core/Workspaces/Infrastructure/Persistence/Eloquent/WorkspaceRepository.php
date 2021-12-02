<?php

namespace Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Models\Workspace as EloquentWorkspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Infrastructure\Exceptions\WorkspaceNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;

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
        $profile = is_string($eloquentWorkspace->profile) ? json_try_decode($eloquentWorkspace->profile, true) : $eloquentWorkspace->profile;
        return Workspace::restore(
            $eloquentWorkspace->id,
            $eloquentWorkspace->keeper_id,
            $eloquentWorkspace->added_at,
            $profile,
        );
    }
}
