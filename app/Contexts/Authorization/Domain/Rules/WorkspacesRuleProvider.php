<?php

namespace App\Contexts\Authorization\Domain\Rules;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForCollaborators;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

class WorkspacesRuleProvider
{
    public array $rules = [];

    public function __construct()
    {
        $allowOnlyForCollaborators = new AllowOnlyForCollaborators();
        $this->rules = [
            AbacRule::of(AuthorizationPermission::WORKSPACE_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::WORKSPACE_CHANGE_PROFILE(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::PLAN_ADD(), $allowOnlyForCollaborators),
        ];
    }
}
