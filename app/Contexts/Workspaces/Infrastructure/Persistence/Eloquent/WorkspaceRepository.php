<?php

namespace App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Models\Workspace as EloquentWorkspace;
use ReflectionClass;

class WorkspaceRepository implements WorkspaceRepositoryInterface
{
    public function persist(Workspace $workspace): void
    {
        EloquentWorkspace::query()->updateOrCreate(
            ['id' => $workspace->workspaceId],
            $this->workspaceAsData($workspace)
        );
    }

    public function take(WorkspaceId $workspaceId): ?Workspace
    {
        /** @var EloquentWorkspace $eloquentWorkspace */
        $eloquentWorkspace = EloquentWorkspace::query()->find((string) $workspaceId);
        return $eloquentWorkspace ? $this->workspaceFromData($eloquentWorkspace) : null;
    }

    private function workspaceAsData(Workspace $workspace): array
    {
        $reflection = new ReflectionClass($workspace);
        $properties = [
            'added' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($workspace);
        }

        return [
            'id' => (string) $workspace->workspaceId,
            'keeper_id' => (string) $workspace->keeperId,
            'added_at' => $properties['added'],
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
