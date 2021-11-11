<?php

namespace App\Contexts\Authorization\Domain\Rules;

use App\Contexts\Authorization\Dictionary\PermissionRepository;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForCollaborators;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

class CardsRuleProvider
{
    public array $rules = [];

    public function __construct()
    {
        $allowOnlyForCollaborators = new AllowOnlyForCollaborators();
        $this->rules = [
            AbacRule::of(PermissionRepository::CARDS_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(PermissionRepository::CARDS_CHANGE(), $allowOnlyForCollaborators),
        ];
    }
}
