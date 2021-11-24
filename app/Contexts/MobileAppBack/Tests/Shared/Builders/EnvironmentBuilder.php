<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Builders;

use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Plan\Requirement as CardRequirement;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Tests\Support\Builders\InviteBuilder;
use App\Contexts\Collaboration\Tests\Support\Builders\RelationBuilder;
use App\Contexts\Identity\Domain\Model\User\User;
use App\Contexts\Identity\Tests\Support\Builders\UserBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\Environment;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\UserLoginInfo;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Contexts\Plans\Tests\Support\Builders\RequirementBuilder;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use App\Shared\Contracts\Tests\BuilderInterface;
use Faker\Factory;
use Faker\Generator;

final class EnvironmentBuilder implements BuilderInterface
{
    public const SMALL_SET_SIZE = 3;
    public const SMALL_SET_MAX = 2;
    public const MEDIUM_SET_SIZE = 6;
    public const MEDIUM_SET_MAX = 5;
    public const LARGE_SET_SIZE = 10;
    public const LARGE_SET_MAX = 9;

    /** @var User[] */
    public array $keepers = [];

    /** @var UserLoginInfo[] */
    public array $keeperInfos = [];

    /** @var User[] */
    public array $collaborators = [];

    /** @var UserLoginInfo[] */
    public array $collaboratorInfos = [];

    /** @var User[] */
    public array $customers = [];

    /** @var UserLoginInfo[] */
    public array $customerInfos = [];

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

    private function __construct(
        private Generator $faker,
        private UserBuilder $userBuilder,
        private WorkspaceBuilder $workspaceBuilder,
        private PlanBuilder $planBuilder,
        private RequirementBuilder $requirementBuilder,
        private CardBuilder $cardBuilder,
        private InviteBuilder $inviteBuilder,
        private RelationBuilder $relationBuilder,
    ) {
    }

    public static function make(): self
    {
        $builder = new self(
            Factory::create(),
            UserBuilder::make(),
            WorkspaceBuilder::make(),
            PlanBuilder::make(),
            RequirementBuilder::make(),
            CardBuilder::make(),
            InviteBuilder::make(),
            RelationBuilder::make(),
        );
        return $builder->generate();
    }

    public function build(): Environment
    {
        return Environment::of(
            $this->keepers,
            $this->keeperInfos,
            $this->collaborators,
            $this->collaboratorInfos,
            $this->customers,
            $this->customerInfos,
            $this->workspaces,
            $this->plans,
            $this->requirements,
            $this->cards,
            $this->invites,
            $this->relations,
        );
    }

    public function generate(): static
    {
        [$this->keepers, $this->keeperInfos] = $this->generateUsers(self::SMALL_SET_SIZE);
        [$this->customers, $this->customerInfos] = $this->generateUsers(self::MEDIUM_SET_SIZE);

        foreach ($this->keepers as $keeper) {
            [$workspaces, $relations] = $this->generateWorkspaces($keeper->userId, 1);
            array_push($this->workspaces, ...$workspaces);
            array_push($this->relations, ...$relations);
        }

        foreach ($this->workspaces as $workspace) {
            $invites = $this->generateInvites($workspace, 1);
            [$collaborators, $collaboratorInfos, $relations] = $this->generateCollaborators($workspace->workspaceId, self::SMALL_SET_SIZE);
            [$plans, $requirements] = $this->generatePlans($workspace->workspaceId);
            array_push($this->invites, ...$invites);
            array_push($this->collaborators, ...$collaborators);
            array_push($this->collaboratorInfos, ...$collaboratorInfos);
            array_push($this->relations, ...$relations);
            array_push($this->plans, ...$plans);
            array_push($this->requirements, ...$requirements);
        }

        for ($i = 0; $i < self::LARGE_SET_SIZE * 10; $i++) {
            $customerId = $this->customers[random_int(1, self::SMALL_SET_MAX)]->userId;
            $plan = $this->plans[random_int(0, self::LARGE_SET_MAX)];
            $requirements = RequirementBuilder::buildSeriesForPlanId($plan->planId, random_int(0, self::LARGE_SET_MAX));
            array_push($this->requirements, ...$requirements);

            $this->cards[] = CardBuilder::make()
                ->withRequirements(...array_map(fn($req) => CardRequirement::of($req->requirementId, $req->getDescription()), $requirements))
                ->withPlanId($plan->planId)
                ->withCustomerId($customerId)
                ->build();
        }

        return $this;
    }

    private function generateUsers(int $quantity): array
    {
        $users = [];
        $userInfos = [];
        $userBuilder = $this->userBuilder;

        for ($i = 0; $i < $quantity; $i++) {
            $users[] = $userBuilder->generate()->build();
            $userInfos[] = UserLoginInfo::of(
                $userBuilder->userId,
                $userBuilder->getIdentity(),
                $userBuilder->plainTextPassword
            );
        }

        return [$users, $userInfos];
    }

    private function generateWorkspaces(string $keeperId, int $quantity): array
    {
        $workspaceBuilder = $this->workspaceBuilder;
        $relationBuilder = $this->relationBuilder;
        $workspaces = [];
        $relations = [];

        for ($i = 0; $i < $quantity; $i++) {
            $workspaces[] = $workspaceBuilder
                ->generate()
                ->withKeeperId($keeperId)
                ->build();

            $relations[] = $relationBuilder->generate()
                ->withKeeperId($keeperId)
                ->withWorkspaceId($workspaceBuilder->workspaceId)
                ->build();
        }

        return [$workspaces, $relations];
    }

    private function generateInvites(Workspace $workspace, int $quantity): array
    {
        $inviteBuilder = $this->inviteBuilder;
        $invites = [];

        for ($i = 0; $i < $quantity; $i++) {
            $invites[] = $inviteBuilder
                ->generate()
                ->withWorkspaceId($workspace->workspaceId)
                ->withInviterId($workspace->keeperId)
                ->build();
        }

        return $invites;
    }

    private function generateCollaborators(string $workspaceId, int $quantity): array
    {
        $relationBuilder = $this->relationBuilder;
        $relations = [];

        $userBuilder = $this->userBuilder;
        $collaborators = [];
        $collaboratorInfos = [];

        for ($i = 0; $i < $quantity; $i++) {
            $collaborators[] = $userBuilder->generate()->build();
            $collaboratorInfos[] = UserLoginInfo::of(
                $userBuilder->userId,
                $userBuilder->getIdentity(),
                $userBuilder->plainTextPassword
            );

            $relations[] = $relationBuilder->generate()
                ->withCollaboratorId($userBuilder->userId)
                ->withWorkspaceId($workspaceId)
                ->build();
        }

        return [
            $collaborators,
            $collaboratorInfos,
            $relations,
        ];
    }

    private function generatePlans(string $workspaceId): array
    {
        $planBuilder = $this->planBuilder;
        $plans = [];

        $requirementBuilder = $this->requirementBuilder;
        $requirements = [];

        $plans[] = $planBuilder->generate()->withWorkspaceId($workspaceId)->build();

        $plans[] = $planBuilder->generate()->withWorkspaceId($workspaceId)->withLaunched()->build();
        array_push($requirements, ...$requirementBuilder::buildSeriesForPlanId($planBuilder->planId, self::SMALL_SET_SIZE));

        $plans[] = $planBuilder->generate()->withWorkspaceId($workspaceId)->withStopped()->build();
        array_push($requirements, ...$requirementBuilder::buildSeriesForPlanId($planBuilder->planId, self::SMALL_SET_SIZE));

        $plans[] = $planBuilder->generate()->withWorkspaceId($workspaceId)->withArchived()->build();

        return [
            $plans,
            $requirements,
        ];
    }
}
