<?php

namespace App\Contexts\MobileAppBack\Tests\Support;

use App\Contexts\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\MobileAppBack\Tests\Shared\Builders\EnvironmentBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\Environment;
use App\Contexts\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;

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
