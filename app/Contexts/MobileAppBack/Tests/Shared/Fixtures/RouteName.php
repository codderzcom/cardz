<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Fixtures;

use MyCLabs\Enum\Enum;

final class RouteName extends Enum
{
    public const GET_TOKEN = 'MABCustomerGetToken';
    public const GET_WORKSPACES = 'MABWorkspaceListAll';
    public const ADD_WORKSPACE = 'MABWorkspaceAdd';
    public const GET_PLANS = 'MABPlanListAll';
    public const ISSUE_CARD = 'MABCardIssue';
    public const GET_CARD = 'MABCardGetCard';
    public const COMPLETE_CARD = 'MABCardComplete';
    public const REVOKE_CARD = 'MABCardRevoke';
    public const BLOCK_CARD = 'MABCardBlock';
    public const UNBLOCK_CARD = 'MABCardUnblock';

    public const NOTE_ACHIEVEMENT = 'MABCardNoteAchievement';
    public const DISMISS_ACHIEVEMENT = 'MABCardDismissAchievement';

    public const ADD_PLAN = 'MABPlanAdd';
    public const CHANGE_PLAN_DESCRIPTION = 'MABPlanChangeDescription';
    public const LAUNCH_PLAN = 'MABPlanLaunch';
    public const STOP_PLAN = 'MABPlanStop';
    public const ARCHIVE_PLAN = 'MABPlanArchive';
    public const ADD_PLAN_REQUIREMENT = 'MABPlanAddRequirement';
    public const REMOVE_PLAN_REQUIREMENT = 'MABPlanRemoveRequirement';
    public const CHANGE_PLAN_REQUIREMENT = 'MABPlanChangeRequirement';
    public const PROPOSE_INVITE = 'MABProposeInvite';
    public const ACCEPT_INVITE = 'MABAcceptInvite';
    public const DISCARD_INVITE = 'MABDiscardInvite';

}
