<?php

namespace Cardz\Generic\Authorization\Domain\Rules;

use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission as Permission;
use Cardz\Generic\Authorization\Domain\Policies\Allow;
use Cardz\Generic\Authorization\Domain\Policies\AllowForCollaborators;
use Cardz\Generic\Authorization\Domain\Policies\AllowForKeeper;
use Cardz\Generic\Authorization\Domain\Policies\DenyForKeeper;
use Codderz\Platypus\Contracts\Authorization\Abac\RuleInterface;
use Codderz\Platypus\Infrastructure\Authorization\Abac\AbacRule as Rule;

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
        $allowForCollaborators = new AllowForCollaborators();
        $allowForKeeper = new AllowForKeeper();
        $denyForKeeper = new DenyForKeeper();
        $allow = new Allow();

        $rules = [
            Rule::of(Permission::WORKSPACE_VIEW(), $allowForCollaborators),
            Rule::of(Permission::WORKSPACE_CHANGE_PROFILE(), $allowForKeeper),
            Rule::of(Permission::PLAN_ADD(), $allowForCollaborators),
            Rule::of(Permission::PLAN_VIEW(), $allowForCollaborators),
            Rule::of(Permission::PLAN_CHANGE(), $allowForCollaborators),
            Rule::of(Permission::PLAN_CARD_ADD(), $allowForCollaborators),
            Rule::of(Permission::CARD_VIEW(), $allowForCollaborators),
            Rule::of(Permission::CARD_CHANGE(), $allowForCollaborators),
            Rule::of(Permission::INVITE_PROPOSE(), $allowForKeeper),
            Rule::of(Permission::INVITE_DISCARD(), $allowForKeeper),
            Rule::of(Permission::COLLABORATION_LEAVE(), $allowForCollaborators, $denyForKeeper),
            Rule::of(Permission::FIRE_COLLABORATOR(), $allowForKeeper),
            Rule::of(Permission::NULL_PERMISSION(), $allow),
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
