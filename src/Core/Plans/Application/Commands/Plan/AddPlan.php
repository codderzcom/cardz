<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\Description;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Model\Plan\WorkspaceId;

final class AddPlan implements PlanCommandInterface
{
    private function __construct(
        private string $planId,
        private string $workspaceId,
        private string $description,
    ) {
    }

    public static function of(string $workspaceId, string $description): self
    {
        return new self(PlanId::makeValue(), $workspaceId, $description);
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

    public function getDescription(): Description
    {
        return Description::of($this->description);
    }

}
