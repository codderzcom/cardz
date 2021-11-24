<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Fixtures;

use MyCLabs\Enum\Enum;

final class RouteName extends Enum
{
    public const GET_TOKEN = 'MABCustomerGetToken';
    public const GET_WORKSPACES = 'MABWorkspaceListAll';
    public const GET_PLANS = 'MABPlanListAll';
    public const ISSUE_CARD = 'MABCardIssue';
    public const ADD_PLAN = 'MABPlanAdd';

}
