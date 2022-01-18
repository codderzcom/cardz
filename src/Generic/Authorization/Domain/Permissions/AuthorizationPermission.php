<?php

namespace Cardz\Generic\Authorization\Domain\Permissions;

use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Codderz\Platypus\Infrastructure\Authorization\Abac\Permission;

/**
 * @method static self WORKSPACE_VIEW()
 * @method static self WORKSPACE_CHANGE_PROFILE()
 * @method static self PLAN_ADD()
 * @method static self PLAN_VIEW()
 * @method static self PLAN_CHANGE()
 * @method static self PLAN_CARD_ADD()
 * @method static self CARD_VIEW()
 * @method static self CARD_CHANGE()
 * @method static self INVITE_PROPOSE()
 * @method static self INVITE_DISCARD()
 * @method static self COLLABORATION_LEAVE()
 * @method static self FIRE_COLLABORATOR()
 * @method static self NULL_PERMISSION()
 */
final class AuthorizationPermission extends Permission
{
    public const WORKSPACE_VIEW = ResourceType::WORKSPACE . '.view';
    public const WORKSPACE_CHANGE_PROFILE = ResourceType::WORKSPACE . '.change_profile';

    public const PLAN_ADD = ResourceType::WORKSPACE . '.plan.add';
    public const PLAN_VIEW = ResourceType::WORKSPACE . '.plan.view';

    public const PLAN_CHANGE = ResourceType::PLAN . '.change';
    public const PLAN_CARD_ADD = ResourceType::PLAN . '.card.add';

    public const CARD_VIEW = ResourceType::CARD . '.view';
    public const CARD_CHANGE = ResourceType::CARD . '.change';

    public const INVITE_PROPOSE = ResourceType::WORKSPACE . '.invite.propose';
    public const INVITE_DISCARD = ResourceType::WORKSPACE . '.invite.discard';

    public const COLLABORATION_LEAVE = ResourceType::WORKSPACE . '.collaboration.leave';
    public const FIRE_COLLABORATOR = ResourceType::WORKSPACE . '.collaboration.fire';

    public const NULL_PERMISSION = ResourceType::NULL;

    public function resourceType(): ResourceType
    {
        $permissionKey = explode('.', (string) $this)[0];
        return new ResourceType($permissionKey);
    }
}
