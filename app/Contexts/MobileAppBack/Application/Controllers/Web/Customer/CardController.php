<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries\CardRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries\GenerateCardCodeRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries\ListAllCardsRequest;
use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerService;
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

    public function generateCardCode(GenerateCardCodeRequest $request): JsonResponse
    {
        return $this->response($this->customerService->getCardCode(
            $request->customerId,
            $request->cardId,
        ));
    }
}
