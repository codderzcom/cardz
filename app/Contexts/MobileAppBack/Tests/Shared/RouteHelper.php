<?php

namespace App\Contexts\MobileAppBack\Tests\Shared;

class RouteHelper
{
    public const MABCustomerGetWorkspaces = 'MABCustomerGetWorkspaces';
    public const MABCustomerGetToken = 'MABCustomerGetToken';
    public const MABCustomerRegister = 'MABCustomerRegister';
    public const MABCustomerId = 'MABCustomerId';
    public const MABCustomerCards = 'MABCustomerCards';
    public const MABCustomerCard = 'MABCustomerGetToken';

    public const MABWorkspaceListAll = 'MABWorkspaceListAll';
    public const MABWorkspaceAdd = 'MABWorkspaceAdd';
    public const MABWorkspaceGet = 'MABWorkspaceGet';
    public const MABWorkspaceChangeProfile = 'MABWorkspaceChangeProfile';

    public const MABCardIssue = 'MABCardIssue';
    public const MABCardGetCard = 'MABCardGetCard';
    public const MABCardComplete = 'MABCardComplete';
    public const MABCardRevoke = 'MABCardRevoke';
    public const MABCardBlock = 'MABCardBlock';
    public const MABCardUnblock = 'MABCardUnblock';
    public const MABCardNoteAchievement = 'MABCardNoteAchievement';
    public const MABCardDismissAchievement = 'MABCardDismissAchievement';

    public const MABPlanListAll = 'MABPlanListAll';
    public const MABPlanAdd = 'MABPlanAdd';
    public const MABPlanGet = 'MABPlanGet';
    public const MABPlanChangeDescription = 'MABPlanChangeDescription';
    public const MABPlanLaunch = 'MABPlanLaunch';
    public const MABPlanStop = 'MABPlanStop';
    public const MABPlanArchive = 'MABPlanArchive';
    public const MABPlanAddRequirement = 'MABPlanAddRequirement';
    public const MABPlanRemoveRequirement = 'MABPlanRemoveRequirement';
    public const MABPlanChangeRequirement = 'MABPlanChangeRequirement';

    public const MABLeaveRelation = 'MABLeaveRelation';
    public const MABProposeInvite = 'MABProposeInvite';
    public const MABAcceptInvite = 'MABAcceptInvite';
    public const MABDiscardInvite = 'MABDiscardInvite';

    public static function getUrl(string $name, array $routeData = [])
    {
        return route($name, $routeData);
    }
}
