<?php

namespace App\Contexts\Authorization\Domain\Rules;

use App\Contexts\Authorization\Dictionary\PermissionRepository;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForCollaborators;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForKeeper;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

class WorkspacesRuleProvider
{
    public array $rules = [];

    public function __construct()
    {
        $allowOnlyForCollaborators = new AllowOnlyForCollaborators();
        $this->rules = [
            AbacRule::of(PermissionRepository::WORKSPACES_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(PermissionRepository::WORKSPACES_CHANGE_PROFILE(), $allowOnlyForCollaborators),
            AbacRule::of(PermissionRepository::WORKSPACES_PLANS_ADD(), $allowOnlyForCollaborators),
        ];
    }
}
