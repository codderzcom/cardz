<?php

namespace Cardz\Core\Workspaces\Domain\ReadModel;

use Carbon\Carbon;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Profile;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

final class AddedWorkspace implements JsonSerializable
{
    use ArrayPresenterTrait;

    public function __construct(
        public string $workspaceId,
        public string $keeperId,
        public Profile $profile,
        public Carbon $added,
    ) {
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    #[Pure]
    public static function of(Workspace $workspace): self
    {
        return new AddedWorkspace(
            $workspace->workspaceId,
            $workspace->keeperId,
            $workspace->profile,
            $workspace->added,
        );
    }
}
