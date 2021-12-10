<?php

namespace Cardz\Support\MobileAppGateway\Tests\Support;

use Cardz\Core\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Domain\ReadModel\AddedWorkspace;
use Cardz\Core\Workspaces\Domain\ReadModel\Contracts\AddedWorkspaceStorageInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\MobileAppGateway\Tests\Shared\Builders\EnvironmentBuilder;
use Cardz\Support\MobileAppGateway\Tests\Shared\Fixtures\Environment;

trait ScenarioTestTrait
{
    protected Environment $environment;

    public function setUpEnvironment(): void
    {
        $this->environment = EnvironmentBuilder::make()->build();
    }

    public function persistEnvironment(): void
    {
        foreach ($this->environment->keepers as $keeper) {
            $this->getUserRepository()->persist($keeper);
            $this->getKeeperRepository()->store(Keeper::register(KeeperId::of($keeper->userId)));
        }
        foreach ($this->environment->collaborators as $collaborator) {
            $this->getUserRepository()->persist($collaborator);
            $this->getKeeperRepository()->store(Keeper::register(KeeperId::of($collaborator->userId)));
        }
        foreach ($this->environment->customers as $customer) {
            $this->getUserRepository()->persist($customer);
            $this->getKeeperRepository()->store(Keeper::register(KeeperId::of($customer->userId)));
        }

        foreach ($this->environment->workspaces as $workspace) {
            $this->getWorkspaceRepository()->store($workspace);
            $this->getWorkspaceReadStore()->persist(AddedWorkspace::of($workspace));
        }

        foreach ($this->environment->plans as $plan) {
            $this->getPlanRepository()->persist($plan);
        }

        foreach ($this->environment->requirements as $requirement) {
            $this->getRequirementRepository()->persist($requirement);
        }

        foreach ($this->environment->cards as $card) {
            $this->getCardRepository()->persist($card);
        }

        foreach ($this->environment->invites as $invite) {
            $this->getInviteRepository()->persist($invite);
        }

        foreach ($this->environment->relations as $relation) {
            $this->getRelationRepository()->persist($relation);
        }

        foreach ($this->environment->resources as $resource) {
            $this->getResourceRepository()->persist($resource);
        }
    }

    public function getUserRepository(): UserRepositoryInterface
    {
        return $this->app->make(UserRepositoryInterface::class);
    }

    public function getKeeperRepository(): KeeperRepositoryInterface
    {
        return $this->app->make(KeeperRepositoryInterface::class);
    }

    public function getWorkspaceReadStore(): AddedWorkspaceStorageInterface
    {
        return $this->app->make(AddedWorkspaceStorageInterface::class);
    }

    public function getWorkspaceRepository(): WorkspaceRepositoryInterface
    {
        return $this->app->make(WorkspaceRepositoryInterface::class);
    }

    public function getPlanRepository(): PlanRepositoryInterface
    {
        return $this->app->make(PlanRepositoryInterface::class);
    }

    public function getRequirementRepository(): RequirementRepositoryInterface
    {
        return $this->app->make(RequirementRepositoryInterface::class);
    }

    public function getCardRepository(): CardRepositoryInterface
    {
        return $this->app->make(CardRepositoryInterface::class);
    }

    public function getInviteRepository(): InviteRepositoryInterface
    {
        return $this->app->make(InviteRepositoryInterface::class);
    }

    public function getRelationRepository(): RelationRepositoryInterface
    {
        return $this->app->make(RelationRepositoryInterface::class);
    }

    public function getResourceRepository(): ResourceRepositoryInterface
    {
        return $this->app->make(ResourceRepositoryInterface::class);
    }
}
