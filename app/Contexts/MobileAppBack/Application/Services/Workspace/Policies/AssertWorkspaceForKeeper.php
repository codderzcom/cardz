<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace\Policies;

use App\Contexts\MobileAppBack\Application\Exceptions\AssertionException;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Models\Workspace as EloquentWorkspace;
use App\Shared\Contracts\PolicyAssertionInterface;
use JetBrains\PhpStorm\Pure;

final class AssertWorkspaceForKeeper implements PolicyAssertionInterface
{
    private function __construct(
        private WorkspaceId $workspaceId,
        private KeeperId $keeperId,
    ) {
    }

    #[Pure]
    public static function of(WorkspaceId $workspaceId, KeeperId $keeperId): self
    {
        return new self($workspaceId, $keeperId);
    }

    public function assert(): void
    {
        $workspace = EloquentWorkspace::query()
            ->where('id', '=', (string) $this->workspaceId)
            ->where('keeper_id', '=', (string) $this->keeperId)
            ->first();
        if ($workspace === null) {
            throw new AssertionException("Workspace {$this->workspaceId} is not for keeper {$this->keeperId}");
        }
    }
}
