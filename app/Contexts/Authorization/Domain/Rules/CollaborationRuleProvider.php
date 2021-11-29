<?php

namespace App\Contexts\Authorization\Domain\Rules;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForCollaborators;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForKeeper;
use App\Contexts\Authorization\Domain\Policies\DenyForKeeper;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

class CollaborationRuleProvider
{
    public array $rules = [];

    public function __construct()
    {
        $allowOnlyForKeeper = new AllowOnlyForKeeper();
        $allowOnlyForCollaborators = new AllowOnlyForCollaborators();
        $denyForKeeper = new DenyForKeeper();
        $this->rules = [
            AbacRule::of(AuthorizationPermission::INVITE_PROPOSE(), $allowOnlyForKeeper),
            AbacRule::of(AuthorizationPermission::INVITE_DISCARD(), $allowOnlyForKeeper),
            AbacRule::of(AuthorizationPermission::COLLABORATION_LEAVE(), $allowOnlyForCollaborators, $denyForKeeper),
        ];
    }
}
