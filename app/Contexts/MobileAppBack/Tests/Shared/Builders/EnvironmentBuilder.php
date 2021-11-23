<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Builders;

use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Plan\Requirement as CardRequirement;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Tests\Support\Builders\InviteBuilder;
use App\Contexts\Identity\Domain\Model\User\User;
use App\Contexts\Identity\Tests\Support\Builders\UserBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\Environment;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Contexts\Plans\Tests\Support\Builders\RequirementBuilder;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use App\Shared\Infrastructure\Tests\BaseBuilder;

final class EnvironmentBuilder extends BaseBuilder
{

    /** @var User[] */
    public array $keepers = [];

    /** @var User[] */
    public array $collaborators = [];

    /** @var User[] */
    public array $customers = [];

    /** @var Workspace[] */
    public array $workspaces = [];

    /** @var Plan[] */
    public array $plans = [];

    /** @var Requirement[] */
    public array $requirements = [];

    /** @var Card[] */
    public array $cards = [];

    /** @var Invite[] */
    public array $invites = [];

    /** @var Relation[] */
    public array $relations = [];

    public function build(): Environment
    {
        return Environment::of();
    }

    public function generate(): static
    {
        for ($i = 0; $i < 3; $i++) {
            $this->keepers[] = UserBuilder::make()->build();
            $this->collaborators[] = UserBuilder::make()->build();
            $this->customers[] = UserBuilder::make()->build();
        }

        $workspaceBuilder = WorkspaceBuilder::make();
        for ($i = 0; $i < 10; $i++) {
            $keeperId = $this->keepers[random_int(0, 2)]->userId;
            $this->workspaces[] = $workspaceBuilder->generate()->withKeeperId($keeperId)->build();
            $this->invites[] = InviteBuilder::make()
                ->withWorkspaceId($workspaceBuilder->workspaceId)
                ->withInviterId($keeperId)
                ->build();
        }

        $planBuilder = PlanBuilder::make();
        for ($i = 0; $i < 10; $i++) {
            $workspaceId = $this->workspaces[random_int(0, 9)]->workspaceId;

            $plan = $planBuilder->generate()->withWorkspaceId($workspaceId)->build();
            $this->plans[] = $plan;
        }

        for ($i = 0; $i < 10; $i++) {
            $customerId = $this->customers[random_int(0, 2)]->userId;
            $plan = $this->plans[random_int(0, 9)];
            $requirements = RequirementBuilder::buildSeriesForPlanId($plan->planId, random_int(0, 10));
            array_push($this->requirements, ...$requirements);

            $this->cards[] = CardBuilder::make()
                ->withRequirements(...array_map(fn($req) => CardRequirement::of($req->requirementId, $req->getDescription()), $requirements))
                ->withPlanId($plan->planId)
                ->withCustomerId($customerId)
                ->build();
        }

        return $this;
    }
}
