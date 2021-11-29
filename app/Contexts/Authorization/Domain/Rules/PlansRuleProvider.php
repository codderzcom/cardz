<?php

namespace App\Contexts\Authorization\Domain\Rules;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForCollaborators;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

class PlansRuleProvider
{
    public array $rules = [];

    public function __construct()
    {
        $allowOnlyForCollaborators = new AllowOnlyForCollaborators();
        $this->rules = [
            AbacRule::of(AuthorizationPermission::PLAN_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::PLAN_CHANGE(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::PLAN_CARD_ADD(), $allowOnlyForCollaborators),
        ];
    }
}
