<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;

interface IssuedCardReadStorageInterface
{
    /**
     * @return IssuedCard[]
     */
    public function allForCustomer(string $customerId): array;

    public function forCustomer(string $customerId, string $cardId): IssuedCard;
}
