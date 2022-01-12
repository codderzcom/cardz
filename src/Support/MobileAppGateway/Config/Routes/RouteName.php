<?php

namespace Cardz\Support\MobileAppGateway\Config\Routes;

use MyCLabs\Enum\Enum;

final class RouteName extends Enum
{
    public const REGISTER = 'CustomerRegister';
    public const GET_TOKEN = 'CustomerGetToken';
    public const GET_WORKSPACES = 'WorkspaceListAll';
    public const ADD_WORKSPACE = 'WorkspaceAdd';
    public const GET_PLANS = 'PlanListAll';
    public const ISSUE_CARD = 'CardIssue';
    public const GET_CARD = 'CardGet';
    public const COMPLETE_CARD = 'CardComplete';
    public const REVOKE_CARD = 'CardRevoke';
    public const BLOCK_CARD = 'CardBlock';
    public const UNBLOCK_CARD = 'CardUnblock';

    public const NOTE_ACHIEVEMENT = 'CardAchievementNote';
    public const DISMISS_ACHIEVEMENT = 'CardAchievementDismiss';

    public const ADD_PLAN = 'PlanAdd';
    public const CHANGE_PLAN_DESCRIPTION = 'PlanChangeDescription';
    public const LAUNCH_PLAN = 'PlanLaunch';
    public const STOP_PLAN = 'PlanStop';
    public const ARCHIVE_PLAN = 'PlanArchive';
    public const ADD_PLAN_REQUIREMENT = 'PlanRequirementAdd';
    public const REMOVE_PLAN_REQUIREMENT = 'PlanRequirementRemove';
    public const CHANGE_PLAN_REQUIREMENT = 'PlanRequirementChange';
    public const PROPOSE_INVITE = 'InvitePropose';
    public const ACCEPT_INVITE = 'InviteAccept';
    public const DISCARD_INVITE = 'InviteDiscard';

    public const LEAVE_RELATION = 'CollaborationLeave';
    public const FIRE_COLLABORATOR = 'CollaborationFire';

    public const GET_WORKSPACE = 'WorkspaceGet';
    public const CHANGE_PROFILE = 'WorkspaceChangeProfile';
    public const GET_PLAN = 'PlanGet';

    public const CUSTOMER_WORKSPACES = 'CustomerWorkspacesGet';
    public const CUSTOMER_ID = 'CustomerIdGet';
    public const CUSTOMER_CARDS = 'CustomerCardsGet';
    public const CUSTOMER_CARD = 'CustomerCardGet';
}
