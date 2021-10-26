<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\GetTokenRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\RegisterRequest;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{
    public function __construct(
        private CustomerService $customerService,
    ) {
    }

    public function getToken(GetTokenRequest $request): JsonResponse
    {
        return $this->response($this->customerService->getToken(
            $request->identity,
            $request->password,
            $request->deviceName,
        ));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->response($this->customerService->register(
            $request->email,
            $request->phone,
            $request->name,
            $request->password,
            $request->deviceName,
        ));
    }
}
