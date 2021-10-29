<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;

interface IssuedCardReadStorageInterface
{
    public function find(string $cardId): IssuedCard;

    /**
     * @param string $planId
     * @return IssuedCard[]
     */
    public function allForPlanId(string $planId): array;

    /**
     * @return IssuedCard[]
     */
    public function allForCustomer(string $customerId): array;

    public function forCustomer(string $customerId, string $cardId): IssuedCard;

    public function forKeeper(string $keeperId, string $workspaceId, string $cardId): IssuedCard;
}
