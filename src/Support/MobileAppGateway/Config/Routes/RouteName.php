<?php

namespace Cardz\Support\MobileAppGateway\Config\Routes;

use MyCLabs\Enum\Enum;

final class RouteName extends Enum
{
    public const REGISTER = 'MAG.Business.CustomerRegister';
    public const GET_TOKEN = 'MAG.Business.CustomerGetToken';
    public const GET_WORKSPACES = 'MAG.Business.WorkspaceListAll';
    public const ADD_WORKSPACE = 'MAG.Business.WorkspaceAdd';
    public const GET_PLANS = 'MAG.Business.PlanListAll';
    public const ISSUE_CARD = 'MAG.Business.CardIssue';
    public const GET_CARD = 'MAG.Business.CardGetCard';
    public const COMPLETE_CARD = 'MAG.Business.CardComplete';
    public const REVOKE_CARD = 'MAG.Business.CardRevoke';
    public const BLOCK_CARD = 'MAG.Business.CardBlock';
    public const UNBLOCK_CARD = 'MAG.Business.CardUnblock';

    public const NOTE_ACHIEVEMENT = 'MAG.Business.CardNoteAchievement';
    public const DISMISS_ACHIEVEMENT = 'MAG.Business.CardDismissAchievement';

    public const ADD_PLAN = 'MAG.Business.PlanAdd';
    public const CHANGE_PLAN_DESCRIPTION = 'MAG.Business.PlanChangeDescription';
    public const LAUNCH_PLAN = 'MAG.Business.PlanLaunch';
    public const STOP_PLAN = 'MAG.Business.PlanStop';
    public const ARCHIVE_PLAN = 'MAG.Business.PlanArchive';
    public const ADD_PLAN_REQUIREMENT = 'MAG.Business.PlanAddRequirement';
    public const REMOVE_PLAN_REQUIREMENT = 'MAG.Business.PlanRemoveRequirement';
    public const CHANGE_PLAN_REQUIREMENT = 'MAG.Business.PlanChangeRequirement';
    public const PROPOSE_INVITE = 'MAG.Business.ProposeInvite';
    public const ACCEPT_INVITE = 'MAG.Business.AcceptInvite';
    public const DISCARD_INVITE = 'MAG.Business.DiscardInvite';

    /* begin untested */
    public const GET_WORKSPACE = 'MAG.Business.GetWorkspace';
    public const CHANGE_PROFILE = 'MAG.Business.ChangeProfile';
    public const LEAVE_RELATION = 'MAG.Business.Leave';
    public const GET_PLAN = 'MAG.Business.GetPlan';

    public const CUSTOMER_WORKSPACES = 'MAG.Customer.GetWorkspaces';
    public const CUSTOMER_ID = 'MAG.Customer.GetId';
    public const CUSTOMER_CARDS = 'MAG.Customer.GetCards';
    public const CUSTOMER_CARD = 'MAG.Customer.GetCard';
    /* end untested */
}
