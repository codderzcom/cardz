<?php

namespace Cardz\Core\Workspaces\Infrastructure\ReadStorage\Eloquent;

use App\Models\Workspace as EloquentWorkspace;
use Cardz\Core\Workspaces\Domain\ReadModel\ReadWorkspace;
use Cardz\Core\Workspaces\Infrastructure\ReadStorage\Contracts\ReadWorkspaceStorageInterface;
use JetBrains\PhpStorm\Pure;

class ReadWorkspaceStorage implements ReadWorkspaceStorageInterface
{
    public function take(?string $worspaceId): ?ReadWorkspace
    {
        if ($worspaceId === null) {
            return null;
        }
        /** @var EloquentWorkspace $eloquentWorkspace */
        $eloquentWorkspace = EloquentWorkspace::query()->where([
            'id' => $worspaceId,
        ])?->first();
        if ($eloquentWorkspace === null) {
            return null;
        }
        return $this->readWorkspaceFromData($eloquentWorkspace);
    }

    #[Pure]
    private function readWorkspaceFromData(EloquentWorkspace $eloquentWorkspace): ReadWorkspace
    {
        $profile = is_string($eloquentWorkspace->profile) ? json_try_decode($eloquentWorkspace->profile) : $eloquentWorkspace->profile;
        return new ReadWorkspace(
            $eloquentWorkspace->id,
            $profile['name'] ?? '',
            $profile['description'] ?? '',
            $profile['address'] ?? '',
        );
    }
}
