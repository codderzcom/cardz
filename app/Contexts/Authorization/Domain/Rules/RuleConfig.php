<?php

namespace App\Contexts\Authorization\Domain\Rules;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForCollaborators;
use App\Contexts\Authorization\Domain\Policies\AllowOnlyForKeeper;
use App\Contexts\Authorization\Domain\Policies\DenyForKeeper;
use App\Shared\Contracts\Authorization\Abac\RuleInterface;
use App\Shared\Infrastructure\Authorization\Abac\AbacRule;

final class RuleConfig
{
    /**
     * @var array
     */
    private array $rules;

    private function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    public static function make(): self
    {
        $allowOnlyForCollaborators = new AllowOnlyForCollaborators();
        $allowOnlyForKeeper = new AllowOnlyForKeeper();
        $denyForKeeper = new DenyForKeeper();

        $rules = [
            AbacRule::of(AuthorizationPermission::WORKSPACE_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::WORKSPACE_CHANGE_PROFILE(), $allowOnlyForKeeper),
            AbacRule::of(AuthorizationPermission::PLAN_ADD(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::PLAN_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::PLAN_CHANGE(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::PLAN_CARD_ADD(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::CARD_VIEW(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::CARD_CHANGE(), $allowOnlyForCollaborators),
            AbacRule::of(AuthorizationPermission::INVITE_PROPOSE(), $allowOnlyForKeeper),
            AbacRule::of(AuthorizationPermission::INVITE_DISCARD(), $allowOnlyForKeeper),
            AbacRule::of(AuthorizationPermission::COLLABORATION_LEAVE(), $allowOnlyForCollaborators, $denyForKeeper),
            AbacRule::of(AuthorizationPermission::NULL_PERMISSION()),
        ];
        return new self(...$rules);
    }

    /**
     * @return RuleInterface[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}
