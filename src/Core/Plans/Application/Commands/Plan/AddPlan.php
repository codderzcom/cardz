<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Model\Plan\Profile;
use Cardz\Core\Plans\Domain\Model\Plan\WorkspaceId;
use JetBrains\PhpStorm\Pure;

final class AddPlan implements PlanCommandInterface
{
    private function __construct(
        private string $planId,
        private string $workspaceId,
        private string $name,
        private string $description,
    ) {
    }

    public static function of(string $workspaceId, string $name, string $description): self
    {
        return new self(PlanId::makeValue(), $workspaceId, $name, $description);
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

    #[Pure]
    public function getProfile(): Profile
    {
        return Profile::of($this->name, $this->description);
    }

}
