<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries\GenerateCustomerCodeRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries\GetTokenRequest;
use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{
    public function __construct(
        private CustomerService $customerService,
    ) {
    }

    public function generateCode(GenerateCustomerCodeRequest $request): JsonResponse
    {
        return $this->response($this->customerService->getCustomerCode(
            $request->customerId,
        ));
    }

    public function getToken(GetTokenRequest $request): JsonResponse
    {
        return $this->response($this->customerService->getToken(
            $request->identity,
            $request->password,
            $request->deviceName,
        ));
    }
}
