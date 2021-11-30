<?php

namespace Cardz\Support\MobileAppGateway\Tests\Support;

use Cardz\Core\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
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
        }
        foreach ($this->environment->collaborators as $collaborator) {
            $this->getUserRepository()->persist($collaborator);
        }
        foreach ($this->environment->customers as $customer) {
            $this->getUserRepository()->persist($customer);
        }

        foreach ($this->environment->workspaces as $workspace) {
            $this->getWorkspaceRepository()->persist($workspace);
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
    }

    public function getUserRepository(): UserRepositoryInterface
    {
        return $this->app->make(UserRepositoryInterface::class);
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
}
