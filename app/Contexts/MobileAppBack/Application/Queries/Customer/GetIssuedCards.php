<?php

namespace App\Contexts\MobileAppBack\Application\Queries\Customer;

use App\Contexts\MobileAppBack\Domain\Model\Customer\CustomerId;
use App\Shared\Contracts\Queries\QueryInterface;

final class GetIssuedCards implements QueryInterface
{
    public function __construct(
        private string $customerId,
    ) {
    }

    public static function of(string $customerId): self
    {
        return new self($customerId);
    }

    public function getCustomerId(): CustomerId
    {
        return CustomerId::of($this->customerId);
    }
}
