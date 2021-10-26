<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer;

use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private CustomerService $customerService,
    ) {
    }

    public function all(): JsonResponse
    {
        return $this->response($this->customerService->getCustomerWorkspaces());
    }
}
