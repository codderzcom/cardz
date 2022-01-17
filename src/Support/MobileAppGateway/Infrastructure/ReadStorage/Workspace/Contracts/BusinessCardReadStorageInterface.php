<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessCard;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\BusinessCardNotFoundException;

interface BusinessCardReadStorageInterface
{
    /**
     * @throws BusinessCardNotFoundException
     */
    public function find(string $cardId): BusinessCard;

    /**
     * @return BusinessCard[]
     */
    public function allForPlan(string $planId): array;

}
