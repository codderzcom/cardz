<?php

namespace App\Contexts\Workspaces\Domain\Model\Workspace;

use App\Contexts\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use App\Contexts\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use App\Contexts\Workspaces\Domain\Model\Shared\AggregateRoot;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Workspace extends AggregateRoot
{
    private ?Carbon $added = null;

    private function __construct(
        public WorkspaceId $workspaceId,
        public KeeperId $keeperId,
        public Profile $profile,
    ) {
    }

    #[Pure]
    public static function make(WorkspaceId $workspaceId, KeeperId $keeperId, Profile $profile): self
    {
        return new self($workspaceId, $keeperId, $profile);
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
        string $workspaceId,
        string $keeperId,
        ?Carbon $added,
        array $profile,
    ): void {
        $this->workspaceId = WorkspaceId::of($workspaceId);
        $this->keeperId = KeeperId::of($keeperId);
        $this->added = $added;
        $this->profile = Profile::ofData($profile);
    }
}
