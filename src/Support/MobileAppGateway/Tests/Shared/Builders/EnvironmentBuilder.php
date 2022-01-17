<?php

namespace Cardz\Support\MobileAppGateway\Tests\Shared\Builders;

use Cardz\Core\Cards\Domain\Model\Card\Card;
use Cardz\Core\Cards\Domain\Model\Plan\Requirement as CardRequirement;
use Cardz\Core\Cards\Tests\Support\Builders\CardBuilder;
use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Cardz\Core\Plans\Tests\Support\Builders\RequirementBuilder;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Tests\Support\Builders\ResourceBuilder;
use Cardz\Generic\Identity\Domain\Model\User\User;
use Cardz\Generic\Identity\Tests\Support\Builders\UserBuilder;
use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;
use Cardz\Support\Collaboration\Tests\Support\Builders\InviteBuilder;
use Cardz\Support\Collaboration\Tests\Support\Builders\RelationBuilder;
use Cardz\Support\MobileAppGateway\Tests\Shared\Fixtures\Environment;
use Cardz\Support\MobileAppGateway\Tests\Shared\Fixtures\UserLoginInfo;
use Codderz\Platypus\Contracts\Tests\BuilderInterface;
use Codderz\Platypus\Exceptions\NotFoundException;
use Faker\Factory;
use Faker\Generator;
use JetBrains\PhpStorm\Pure;

final class EnvironmentBuilder implements BuilderInterface
{
    public const SMALL_SET_SIZE = 2;
    public const MEDIUM_SET_SIZE = 3;

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

    /** @var Resource[] */
    public array $resources = [];

    private function __construct(
        private Generator $faker,
        private UserBuilder $userBuilder,
        private WorkspaceBuilder $workspaceBuilder,
        private PlanBuilder $planBuilder,
        private RequirementBuilder $requirementBuilder,
        private CardBuilder $cardBuilder,
        private InviteBuilder $inviteBuilder,
        private RelationBuilder $relationBuilder,
        private ResourceBuilder $resourceBuilder,
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
            ResourceBuilder::make(),
        );
        return $builder->generate();
    }

    public function build(): Environment
    {
        $this->resources = $this->generateResources();
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
            $this->resources,
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

        foreach ($this->plans as $plan) {
            $cards = $this->generateCards($plan->planId);
            array_push($this->cards, ...$cards);
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
        array_push($requirements, ...$requirementBuilder::buildSeriesForPlanId($planBuilder->planId, self::MEDIUM_SET_SIZE));

        $plans[] = $planBuilder->generate()->withWorkspaceId($workspaceId)->withStopped()->build();
        array_push($requirements, ...$requirementBuilder::buildSeriesForPlanId($planBuilder->planId, self::MEDIUM_SET_SIZE));

        $plans[] = $planBuilder->generate()->withWorkspaceId($workspaceId)->withArchived()->build();

        return [
            $plans,
            $requirements,
        ];
    }

    private function generateCards(string $planId): array
    {
        $cardBuilder = $this->cardBuilder;
        $cards = [];
        $requirements = $this->requirementsByPlanId($planId);

        $customerId = $this->customers[1]->userId;
        $cards[] = $cardBuilder
            ->withRequirements(...array_map(static fn($req) => CardRequirement::of($req->requirementId, $req->getDescription()), $requirements))
            ->withPlanId($planId)
            ->withCustomerId($customerId)
            ->build();

        $customerId = $this->customers[2]->userId;
        $cards[] = $cardBuilder
            ->withRequirements(...array_map(static fn($req) => CardRequirement::of($req->requirementId, $req->getDescription()), $requirements))
            ->withPlanId($planId)
            ->withCustomerId($customerId)
            ->build();
        return $cards;
    }

    #[Pure]
    private function requirementsByPlanId(string $planId): array
    {
        $requirements = [];
        foreach ($this->requirements as $index => $requirement) {
            if ($requirement->planId->is($planId)) {
                $requirements[$index] = $requirement;
            }
        }
        return $requirements;
    }

    private function generateResources(): array
    {
        $resources = [];
        foreach ($this->keepers as $keeper) {
            $resources[] = $this->resourceBuilder->buildSubject($keeper->userId);
        }
        foreach ($this->collaborators as $collaborator) {
            $resources[] = $this->resourceBuilder->buildSubject($collaborator->userId);
        }
        foreach ($this->customers as $customer) {
            $resources[] = $this->resourceBuilder->buildSubject($customer->userId);
        }

        foreach ($this->workspaces as $workspace) {
            $resources[] = $this->resourceBuilder->buildWorkspace($workspace->workspaceId, $workspace->keeperId);
        }

        foreach ($this->plans as $plan) {
            $resources[] = $this->resourceBuilder->buildPlan(
                $plan->planId,
                $plan->workspaceId,
                $this->getWorkspace($plan->workspaceId)->keeperId,
            );
        }

        foreach ($this->cards as $card) {
            $plan = $this->getPlan($card->planId);
            $resources[] = $this->resourceBuilder->buildCard(
                $card->cardId,
                $card->customerId,
                $card->planId,
                $plan->workspaceId,
                $this->getWorkspace($plan->workspaceId)->keeperId,
            );
        }

        foreach ($this->relations as $relation) {
            $resources[] = $this->resourceBuilder->withResourceId($relation->relationId)->buildRelation(
                $relation->collaboratorId,
                $relation->workspaceId,
                $relation->relationType,
            );
        }
        return $resources;
    }

    private function getWorkspace(string $workspaceId): Workspace
    {
        foreach ($this->workspaces as $workspace) {
            if ($workspace->workspaceId->is($workspaceId)) {
                return $workspace;
            }
        }
        throw new NotFoundException();
    }

    private function getPlan(string $planId): Plan
    {
        foreach ($this->plans as $plan) {
            if ($plan->planId->is($planId)) {
                return $plan;
            }
        }
        throw new NotFoundException();
    }
}
