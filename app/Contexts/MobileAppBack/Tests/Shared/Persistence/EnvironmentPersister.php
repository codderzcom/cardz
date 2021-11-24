<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Persistence;

use App\Contexts\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;

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
