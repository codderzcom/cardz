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

        $data = [
            'id' => (string) $workspace->workspaceId,
            'profile' => json_try_encode($workspace->profile->toArray()),
            'added_at' => $properties['added'],
        ];
        return $data;
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

    private function workspaceFromData(EloquentWorkspace $eloquentWorkspace): Workspace
    {
        $reflection = new ReflectionClass(Workspace::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Workspace $workspace */
        $workspace = $reflection->newInstanceWithoutConstructor();

        $creator?->invoke($workspace,
            $eloquentWorkspace->id,
            $eloquentWorkspace->profile,
            $eloquentWorkspace->added_at,
        );
        return $workspace;
    }
}
