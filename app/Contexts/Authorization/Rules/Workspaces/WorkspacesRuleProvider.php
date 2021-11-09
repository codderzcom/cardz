<?php

namespace App\Contexts\Authorization\Rules\Workspaces;

use App\Contexts\Authorization\Dictionary\PermissionRepository;
use App\Contexts\Authorization\Policies\AllowOnlyForCollaborators;
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
        ];
    }
}
