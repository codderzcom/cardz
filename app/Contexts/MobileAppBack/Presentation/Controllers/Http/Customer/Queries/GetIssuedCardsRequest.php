<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries;

use App\Contexts\MobileAppBack\Application\Queries\Customer\GetIssuedCards;

class GetIssuedCardsRequest extends BaseCustomerQueryRequest
{

    public function toQuery(): GetIssuedCards
    {
        return GetIssuedCards::of($this->customerId);
    }
}
