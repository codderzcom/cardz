<?php

namespace App\Contexts\Authorization\Tests\Feature;

use App\Contexts\Authorization\Application\AuthorizationBusInterface;
use App\Contexts\Authorization\Application\Queries\IsAllowed;
use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Cards\Tests\Support\Mocks\CardInMemoryRepository;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Tests\Support\Builders\InviteBuilder;
use App\Contexts\Collaboration\Tests\Support\Builders\RelationBuilder;
use App\Contexts\Collaboration\Tests\Support\Mocks\InviteInMemoryRepository;
use App\Contexts\Collaboration\Tests\Support\Mocks\RelationInMemoryRepository;
use App\Contexts\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Identity\Tests\Support\Builders\UserBuilder;
use App\Contexts\Identity\Tests\Support\Mocks\UserInMemoryRepository;
use App\Contexts\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Contexts\Plans\Tests\Support\Mocks\PlanInMemoryRepository;
use App\Contexts\Plans\Tests\Support\Mocks\RequirementInMemoryRepository;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use App\Contexts\Workspaces\Tests\Support\Mocks\WorkspaceInMemoryRepository;
use App\Shared\Contracts\GeneralIdInterface;

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
