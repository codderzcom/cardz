<?php

namespace App\Contexts\Authorization\Rules\Workspaces;

use App\Contexts\Authorization\Policies\AllowOnlyForCollaborators;
use App\Shared\Infrastructure\Authorization\Abac\AbacPermission;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

class WorkspacesRuleProvider
{
    private const PREFIX = 'workspaces.';

    public array $rules = [];

    public function __construct()
    {
        $allowForCollaborators = new AllowOnlyForCollaborators();
        $this->rules = [
            AbacRule::of(AbacPermission::of(static::PREFIX . 'view'), $allowForCollaborators),
            AbacRule::of(AbacPermission::of(static::PREFIX . 'changeProfile'), $allowForCollaborators),
        ];
    }
}
