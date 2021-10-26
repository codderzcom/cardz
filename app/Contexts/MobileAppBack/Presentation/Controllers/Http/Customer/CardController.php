<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\CardRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\GenerateCardCodeRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\ListAllCardsRequest;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CustomerService $customerService,
    ) {
    }

    public function getCards(ListAllCardsRequest $request): JsonResponse
    {
        return $this->response($this->customerService->getIssuedCards(
            $request->customerId,
        ));
    }

    public function getCard(CardRequest $request): JsonResponse
    {
        return $this->response($this->customerService->getIssuedCard(
            $request->customerId,
            $request->cardId,
        ));
    }

}
