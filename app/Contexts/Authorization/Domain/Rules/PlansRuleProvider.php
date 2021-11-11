<?php

namespace App\Contexts\Authorization\Domain\Rules;

use App\Contexts\Authorization\Dictionary\PermissionRepository;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForCollaborators;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

class PlansRuleProvider
{
    public array $rules = [];

    public function __construct()
    {
        $allowOnlyForCollaborators = new AllowOnlyForCollaborators();
        $this->rules = [
            AbacRule::of(PermissionRepository::PLANS_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(PermissionRepository::PLANS_CHANGE(), $allowOnlyForCollaborators),
            AbacRule::of(PermissionRepository::PLANS_CARDS_ADD(), $allowOnlyForCollaborators),
        ];
    }
}
