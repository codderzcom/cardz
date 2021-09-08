<?php

namespace App\Contexts\Workspaces\Infrastructure\Persistence;

use App\Contexts\Workspaces\Application\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Models\Workspace as EloquentWorkspace;
use ReflectionClass;

class WorkspaceRepository implements WorkspaceRepositoryInterface
{
    public function persist(?Workspace $workspace): void
    {
        if ($workspace === null) {
            return;
        }

        EloquentWorkspace::query()->updateOrCreate(
            ['id' => $workspace->workspaceId],
            $this->workspaceAsData($workspace)
        );
    }

    public function take(WorkspaceId $workspaceId): ?Workspace
    {
        /** @var EloquentWorkspace $eloquentWorkspace */
        $eloquentWorkspace = EloquentWorkspace::query()->where([
            'id' => (string) $workspaceId,
        ])?->first();
        if ($eloquentWorkspace === null) {
            return null;
        }
        return $this->workspaceFromData($eloquentWorkspace);
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
        $reflection = new ReflectionClass(Workspace::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Workspace $workspace */
        $workspace = $reflection->newInstanceWithoutConstructor();

        $profile = is_string($eloquentWorkspace->profile) ? json_try_decode($eloquentWorkspace->profile) : $eloquentWorkspace->profile;

        $creator?->invoke($workspace,
            $eloquentWorkspace->id,
            $eloquentWorkspace->keeper_id,
            $eloquentWorkspace->added_at,
            $profile,
        );
        return $workspace;
    }
}
