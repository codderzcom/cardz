<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Requests\GetIssuedCardRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Requests\GetIssuedCardsRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Requests\GetTokenRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{
    public function __construct(
        private CustomerAppService $customerAppService,
    ) {
    }

    public function getToken(GetTokenRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->getToken(
            $request->identity,
            $request->password,
            $request->deviceName,
        ));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->register(
            $request->email,
            $request->phone,
            $request->name,
            $request->password,
            $request->deviceName,
        ));
    }

    public function getCards(GetIssuedCardsRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->getIssuedCards($request->customerId));
    }

    public function getCard(GetIssuedCardRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->getIssuedCards($request->customerId, $request->cardId));
    }

    public function getWorkspaces(): JsonResponse
    {
        return $this->response($this->customerAppService->getCustomerWorkspaces());
    }

}
