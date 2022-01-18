<?php

namespace Cardz\Generic\Authorization\Domain\Policies;

use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission as Permission;
use Cardz\Generic\Authorization\Domain\Rules\AllowForEveryone;
use Cardz\Generic\Authorization\Domain\Rules\AllowForCollaborators;
use Cardz\Generic\Authorization\Domain\Rules\AllowForKeeper;
use Cardz\Generic\Authorization\Domain\Rules\DenyForKeeper;
use Codderz\Platypus\Contracts\Authorization\Abac\PolicyInterface;
use Codderz\Platypus\Infrastructure\Authorization\Abac\Policy as Policy;

final class PolicyConfig
{
    /**
     * @var array
     */
    private array $policies;

    private function __construct(PolicyInterface ...$policies)
    {
        $this->policies = $policies;
    }

    public static function make(): self
    {
        $allowForCollaborators = new AllowForCollaborators();
        $allowForKeeper = new AllowForKeeper();
        $denyForKeeper = new DenyForKeeper();
        $allowForEveryone = new AllowForEveryone();

        $rules = [
            Policy::of(Permission::WORKSPACE_VIEW(), $allowForCollaborators),
            Policy::of(Permission::WORKSPACE_CHANGE_PROFILE(), $allowForKeeper),
            Policy::of(Permission::PLAN_ADD(), $allowForCollaborators),
            Policy::of(Permission::PLAN_VIEW(), $allowForCollaborators),
            Policy::of(Permission::PLAN_CHANGE(), $allowForCollaborators),
            Policy::of(Permission::PLAN_CARD_ADD(), $allowForCollaborators),
            Policy::of(Permission::CARD_VIEW(), $allowForCollaborators),
            Policy::of(Permission::CARD_CHANGE(), $allowForCollaborators),
            Policy::of(Permission::INVITE_PROPOSE(), $allowForKeeper),
            Policy::of(Permission::INVITE_DISCARD(), $allowForKeeper),
            Policy::of(Permission::COLLABORATION_LEAVE(), $allowForCollaborators, $denyForKeeper),
            Policy::of(Permission::FIRE_COLLABORATOR(), $allowForKeeper),
            Policy::of(Permission::NULL_PERMISSION(), $allowForEveryone),
        ];
        return new self(...$rules);
    }

    /**
     * @return PolicyInterface[]
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }
}
