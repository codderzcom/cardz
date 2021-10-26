<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;

interface IssuedCardReadStorageInterface
{
    public function find(string $cardId): ?IssuedCard;

    /**
     * @param string $planId
     * @return IssuedCard[]
     */
    public function allForPlanId(string $planId): array;

    /**
     * @param string $customerId
     * @return IssuedCard[]
     */
    public function allForCustomerId(string $customerId): array;
}
