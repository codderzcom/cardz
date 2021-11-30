<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessCard;

interface BusinessCardReadStorageInterface
{
    public function find(string $cardId): BusinessCard;

    /**
     * @return BusinessCard[]
     */
    public function allForPlan(string $planId): array;

}
