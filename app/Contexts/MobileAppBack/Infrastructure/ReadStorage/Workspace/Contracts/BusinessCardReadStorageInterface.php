<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessCard;

interface BusinessCardReadStorageInterface
{
    public function find(string $cardId): BusinessCard;

    /**
     * @return BusinessCard[]
     */
    public function allForPlan(string $planId): array;

}
