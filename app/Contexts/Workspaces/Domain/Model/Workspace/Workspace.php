<?php

namespace App\Contexts\Workspaces\Domain\Model\Workspace;

use App\Contexts\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use App\Contexts\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Workspace
{
    private ?Carbon $added = null;

    private function __construct(
        public WorkspaceId $workspaceId,
        public Profile $profile,
    ) {
    }

    #[Pure]
    public static function create(WorkspaceId $workspaceId, Profile $profile): static
    {
        return new static($workspaceId, $profile);
    }

    public function add(): WorkspaceAdded
    {
        $this->added = Carbon::now();
        return WorkspaceAdded::with($this->workspaceId);
    }

    public function changeProfile(Profile $profile): WorkspaceProfileChanged
    {
        $this->profile = $profile;
        return WorkspaceProfileChanged::with($this->workspaceId);
    }

    public function isAdded(): bool
    {
        return $this->added !== null;
    }

    private function from(
        ?string $workspaceId,
        $profile = null,
        ?Carbon $added = null,
    ): void {
        $this->workspaceId = new WorkspaceId($workspaceId);
        $this->profile = Profile::fromData($profile);
        $this->added = $added;
    }
}
