<?php

namespace Cardz\Generic\Authorization\Tests\Feature;

use Cardz\Core\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use Cardz\Core\Cards\Tests\Support\Builders\CardBuilder;
use Cardz\Core\Cards\Tests\Support\Mocks\CardInMemoryRepository;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Cardz\Core\Plans\Tests\Support\Mocks\PlanInMemoryRepository;
use Cardz\Core\Plans\Tests\Support\Mocks\RequirementInMemoryRepository;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use Cardz\Core\Workspaces\Tests\Support\Mocks\WorkspaceInMemoryRepository;
use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Tests\Support\Builders\UserBuilder;
use Cardz\Generic\Identity\Tests\Support\Mocks\UserInMemoryRepository;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Tests\Support\Builders\InviteBuilder;
use Cardz\Support\Collaboration\Tests\Support\Builders\RelationBuilder;
use Cardz\Support\Collaboration\Tests\Support\Mocks\InviteInMemoryRepository;
use Cardz\Support\Collaboration\Tests\Support\Mocks\RelationInMemoryRepository;
use Codderz\Platypus\Contracts\GeneralIdInterface;

trait AuthTestHelperTrait
{
    protected GeneralIdInterface $keeperId;

    protected GeneralIdInterface $collaboratorId;

    protected GeneralIdInterface $strangerId;

    protected GeneralIdInterface $workspaceId;

    protected GeneralIdInterface $planId;

    protected GeneralIdInterface $cardId;

    protected GeneralIdInterface $inviteId;

    protected function setupApplication(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserInMemoryRepository::class);
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceInMemoryRepository::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanInMemoryRepository::class);
        $this->app->singleton(RequirementRepositoryInterface::class, RequirementInMemoryRepository::class);
        $this->app->singleton(CardRepositoryInterface::class, CardInMemoryRepository::class);
        $this->app->singleton(RelationRepositoryInterface::class, RelationInMemoryRepository::class);
        $this->app->singleton(InviteRepositoryInterface::class, InviteInMemoryRepository::class);
    }

    protected function getUserRepository(): UserRepositoryInterface
    {
        return $this->app->make(UserRepositoryInterface::class);
    }

    protected function getWorkspaceRepository(): WorkspaceRepositoryInterface
    {
        return $this->app->make(WorkspaceRepositoryInterface::class);
    }

    protected function getPlanRepository(): PlanRepositoryInterface
    {
        return $this->app->make(PlanRepositoryInterface::class);
    }

    protected function getRequirementRepository(): RequirementRepositoryInterface
    {
        return $this->app->make(RequirementRepositoryInterface::class);
    }

    protected function getCardRepository(): CardRepositoryInterface
    {
        return $this->app->make(CardRepositoryInterface::class);
    }

    protected function getRelationRepository(): RelationRepositoryInterface
    {
        return $this->app->make(RelationRepositoryInterface::class);
    }

    protected function getInviteRepository(): InviteRepositoryInterface
    {
        return $this->app->make(InviteRepositoryInterface::class);
    }

    protected function authorizationBus(): AuthorizationBusInterface
    {
        return $this->app->make(AuthorizationBusInterface::class);
    }

    protected function assertGranted(AuthorizationPermission $permission, GeneralIdInterface $subjectId, GeneralIdInterface $objectId): void
    {
        $result = $this->authorizationBus()->execute(IsAllowed::of($permission, $subjectId, $objectId));
        $this->assertTrue($result, "Permission $permission should be granted");
    }

    protected function assertDenied(AuthorizationPermission $permission, GeneralIdInterface $subjectId, GeneralIdInterface $objectId): void
    {
        $result = $this->authorizationBus()->execute(IsAllowed::of($permission, $subjectId, $objectId));
        $this->assertFalse($result, "Permission $permission should be denied");
    }

    protected function setupEnvironment(): void
    {
        $keeper = UserBuilder::make()->build();
        $this->getUserRepository()->persist($keeper);
        $this->keeperId = $keeper->userId;

        $collaborator = UserBuilder::make()->build();
        $this->getUserRepository()->persist($collaborator);
        $this->collaboratorId = $collaborator->userId;

        $stranger = UserBuilder::make()->build();
        $this->getUserRepository()->persist($stranger);
        $this->strangerId = $stranger->userId;

        $workspace = WorkspaceBuilder::make()->withKeeperId($this->keeperId)->build();
        $this->getWorkspaceRepository()->persist($workspace);
        $this->workspaceId = $workspace->workspaceId;

        $plan = PlanBuilder::make()->withWorkspaceId($this->workspaceId)->build();
        $this->getPlanRepository()->persist($plan);
        $this->planId = $plan->planId;

        $card = CardBuilder::make()
            ->withPlanId($this->planId)
            ->withCustomerId($this->strangerId)
            ->build();
        $this->getCardRepository()->persist($card);
        $this->cardId = $card->cardId;

        $invite = InviteBuilder::make()
            ->withInviterId($workspace->keeperId)
            ->withWorkspaceId($this->workspaceId)
            ->build();
        $this->getInviteRepository()->persist($invite);
        $this->inviteId = $invite->inviteId;

        $relation = RelationBuilder::make()
            ->withKeeperId($this->keeperId)
            ->withWorkspaceId($this->workspaceId)
            ->build();
        $this->getRelationRepository()->persist($relation);

        $relation = RelationBuilder::make()
            ->withCollaboratorId($this->collaboratorId)
            ->withWorkspaceId($this->workspaceId)
            ->build();
        $this->getRelationRepository()->persist($relation);
    }

}
