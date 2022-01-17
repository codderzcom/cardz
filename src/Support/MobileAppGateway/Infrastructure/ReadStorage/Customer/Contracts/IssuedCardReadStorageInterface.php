<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Customer\IssuedCard;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\IssuedCardNotFoundException;

interface IssuedCardReadStorageInterface
{
    /**
     * @return IssuedCard[]
     */
    public function allForCustomer(string $customerId): array;

    /**
     * @throws IssuedCardNotFoundException
     */
    public function forCustomer(string $customerId, string $cardId): IssuedCard;
}
