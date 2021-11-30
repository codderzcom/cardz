<?php

namespace Cardz\Core\Workspaces\Domain\Model\Workspace;

use Carbon\Carbon;
use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;

final class Workspace implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $added = null;

    private function __construct(
        public WorkspaceId $workspaceId,
        public KeeperId $keeperId,
        public Profile $profile,
    ) {
    }

    public static function add(WorkspaceId $workspaceId, KeeperId $keeperId, Profile $profile): self
    {
        $workspace = new self($workspaceId, $keeperId, $profile);
        $workspace->added = Carbon::now();

        return $workspace->withEvents(WorkspaceAdded::of($workspace));
    }

    public static function restore(string $workspaceId, string $keeperId, ?Carbon $added, array $profile): self
    {
        $workspace = new self(WorkspaceId::of($workspaceId), KeeperId::of($keeperId), Profile::ofData($profile));
        $workspace->added = $added;
        return $workspace;
    }

    public function changeProfile(Profile $profile): self
    {
        $this->profile = $profile;
        return $this->withEvents(WorkspaceProfileChanged::of($this));
    }

    public function isAdded(): bool
    {
        return $this->added !== null;
    }
}
