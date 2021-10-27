<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries;

use App\Contexts\MobileAppBack\Application\Queries\Customer\GetIssuedCard;

final class GetIssuedCardRequest extends BaseCustomerCardQueryRequest
{
    public function toQuery(): GetIssuedCard
    {
        return GetIssuedCard::of($this->customerId, $this->cardId);
    }
}
