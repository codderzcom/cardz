<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Fixtures;

use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Identity\Domain\Model\User\User;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;

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
        );
    }
}
