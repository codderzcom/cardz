<?php

namespace App\Contexts\MobileAppBack\Application\Queries\Customer;

use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Customer\CustomerId;
use App\Shared\Contracts\Queries\QueryInterface;

final class GetIssuedCard implements QueryInterface
{
    public function __construct(
        private string $customerId,
        private string $cardId,
    ) {
    }

    public static function of(string $customerId, string $cardId): self
    {
        return new self($customerId, $cardId);
    }

    public function getCustomerId(): CustomerId
    {
        return CustomerId::of($this->customerId);
    }

    public function getCardId(): CardId
    {
        return CardId::of($this->cardId);
    }
}
