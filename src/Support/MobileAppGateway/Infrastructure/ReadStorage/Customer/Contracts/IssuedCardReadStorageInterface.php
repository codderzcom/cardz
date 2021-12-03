<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Customer\IssuedCard;

interface IssuedCardReadStorageInterface
{
    /**
     * @return IssuedCard[]
     */
    public function allForCustomer(string $customerId): array;

    public function forCustomer(string $customerId, string $cardId): IssuedCard;
}
