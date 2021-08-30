<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{
    public function generateCode(GenerateCodeRequest $request): JsonResponse
    {
        return $this->success();
    }

    public function listAllCards(ListAllCardsRequest $request): JsonResponse
    {
        return $this->success();
    }
}
