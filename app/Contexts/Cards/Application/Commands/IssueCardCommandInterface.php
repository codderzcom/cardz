<?php

namespace App\Contexts\Cards\Application\Commands;

use App\Contexts\Cards\Domain\Model\Card\CustomerId;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;

interface IssueCardCommandInterface extends CardCommandInterface
{
    public function getPlanId(): PlanId;

    public function getCustomerId(): CustomerId;
}
