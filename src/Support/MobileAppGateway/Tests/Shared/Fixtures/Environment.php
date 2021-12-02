<?php

namespace Cardz\Support\MobileAppGateway\Tests\Shared\Fixtures;

use Cardz\Core\Cards\Domain\Model\Card\Card;
use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Identity\Domain\Model\User\User;
use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;

class Environment
{
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
        array $keepers,
        array $keeperInfos,
        array $collaborators,
        array $collaboratorInfos,
        array $customers,
        array $customerInfos,
        array $workspaces,
        array $plans,
        array $requirements,
        array $cards,
        array $invites,
        array $relations,
        array $resources,
    ) {
        $this->keepers = $keepers;
        $this->keeperInfos = $keeperInfos;
        $this->collaborators = $collaborators;
        $this->collaboratorInfos = $collaboratorInfos;
        $this->customers = $customers;
        $this->customerInfos = $customerInfos;
        $this->workspaces = $workspaces;
        $this->plans = $plans;
        $this->requirements = $requirements;
        $this->cards = $cards;
        $this->invites = $invites;
        $this->relations = $relations;
        $this->resources = $resources;
    }

    public static function of(
        array $keepers,
        array $keeperInfos,
        array $collaborators,
        array $collaboratorInfos,
        array $customers,
        array $customerInfos,
        array $workspaces,
        array $plans,
        array $requirements,
        array $cards,
        array $invites,
        array $relations,
        array $resources,
    ): static {
        return new static(
            $keepers,
            $keeperInfos,
            $collaborators,
            $collaboratorInfos,
            $customers,
            $customerInfos,
            $workspaces,
            $plans,
            $requirements,
            $cards,
            $invites,
            $relations,
            $resources,
        );
    }
}
