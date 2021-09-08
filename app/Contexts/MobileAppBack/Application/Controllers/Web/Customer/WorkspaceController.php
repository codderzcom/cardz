<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Services\Customer\CustomerService;
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
