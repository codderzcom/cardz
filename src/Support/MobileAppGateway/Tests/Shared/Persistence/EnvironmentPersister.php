<?php

namespace Cardz\Support\MobileAppGateway\Tests\Shared\Persistence;

use Cardz\Core\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;

class EnvironmentPersister
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private PlanRepositoryInterface $planRepository,
        private RequirementRepositoryInterface $requirementRepository,
        private CardRepositoryInterface $cardRepository,
        private InviteRepositoryInterface $inviteRepository,
        private RelationRepositoryInterface $relationRepository,
    ) {
    }

    public static function of(
        UserRepositoryInterface $userRepository,
        WorkspaceRepositoryInterface $workspaceRepository,
        PlanRepositoryInterface $planRepository,
        RequirementRepositoryInterface $requirementRepository,
        CardRepositoryInterface $cardRepository,
        InviteRepositoryInterface $inviteRepository,
        RelationRepositoryInterface $relationRepository,
    ): static {
        return new static(
            $userRepository,
            $workspaceRepository,
            $planRepository,
            $requirementRepository,
            $cardRepository,
            $inviteRepository,
            $relationRepository,
        );
    }
}
