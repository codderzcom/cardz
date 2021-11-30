<?php

namespace Cardz\Support\MobileAppGateway\Config\Authorization;

use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;

final class RouteNameToPermissionMap
{
    private array $permissionMap = [
        RouteName::REGISTER => AuthorizationPermission::NULL_PERMISSION,
        RouteName::GET_TOKEN => AuthorizationPermission::NULL_PERMISSION,

        RouteName::GET_WORKSPACES => AuthorizationPermission::WORKSPACE_VIEW,
        RouteName::ADD_WORKSPACE => AuthorizationPermission::NULL_PERMISSION,
        RouteName::GET_PLANS => AuthorizationPermission::PLAN_VIEW,
        RouteName::ISSUE_CARD => AuthorizationPermission::PLAN_CARD_ADD,
        RouteName::GET_CARD => AuthorizationPermission::CARD_VIEW,
        RouteName::COMPLETE_CARD => AuthorizationPermission::CARD_CHANGE,
        RouteName::REVOKE_CARD => AuthorizationPermission::CARD_CHANGE,
        RouteName::BLOCK_CARD => AuthorizationPermission::CARD_CHANGE,
        RouteName::UNBLOCK_CARD => AuthorizationPermission::CARD_CHANGE,

        RouteName::NOTE_ACHIEVEMENT => AuthorizationPermission::CARD_CHANGE,
        RouteName::DISMISS_ACHIEVEMENT => AuthorizationPermission::CARD_CHANGE,

        RouteName::ADD_PLAN => AuthorizationPermission::PLAN_ADD,
        RouteName::CHANGE_PLAN_DESCRIPTION => AuthorizationPermission::PLAN_CHANGE,
        RouteName::LAUNCH_PLAN => AuthorizationPermission::PLAN_CHANGE,
        RouteName::STOP_PLAN => AuthorizationPermission::PLAN_CHANGE,
        RouteName::ARCHIVE_PLAN => AuthorizationPermission::PLAN_CHANGE,
        RouteName::ADD_PLAN_REQUIREMENT => AuthorizationPermission::PLAN_CHANGE,
        RouteName::REMOVE_PLAN_REQUIREMENT => AuthorizationPermission::PLAN_CHANGE,
        RouteName::CHANGE_PLAN_REQUIREMENT => AuthorizationPermission::PLAN_CHANGE,
        RouteName::PROPOSE_INVITE => AuthorizationPermission::INVITE_PROPOSE,
        RouteName::ACCEPT_INVITE => AuthorizationPermission::NULL_PERMISSION,
        RouteName::DISCARD_INVITE => AuthorizationPermission::INVITE_PROPOSE,

        RouteName::GET_WORKSPACE => AuthorizationPermission::WORKSPACE_VIEW,
        RouteName::CHANGE_PROFILE => AuthorizationPermission::NULL_PERMISSION,
        RouteName::LEAVE_RELATION => AuthorizationPermission::COLLABORATION_LEAVE,
        RouteName::GET_PLAN => AuthorizationPermission::PLAN_VIEW,

        RouteName::CUSTOMER_WORKSPACES => AuthorizationPermission::NULL_PERMISSION,
        RouteName::CUSTOMER_ID => AuthorizationPermission::NULL_PERMISSION,
        RouteName::CUSTOMER_CARDS => AuthorizationPermission::NULL_PERMISSION,
        RouteName::CUSTOMER_CARD => AuthorizationPermission::NULL_PERMISSION,
    ];

    public static function map(?string $routeName): AuthorizationPermission
    {
        $map = new self();
        return new AuthorizationPermission($map->getPermissionName($routeName));
    }

    private function getPermissionName(?string $routeName): string
    {
        if ($routeName === null) {
            return AuthorizationPermission::NULL_PERMISSION;
        }
        return $this->permissionMap[$routeName] ?? AuthorizationPermission::NULL_PERMISSION;
    }
}
