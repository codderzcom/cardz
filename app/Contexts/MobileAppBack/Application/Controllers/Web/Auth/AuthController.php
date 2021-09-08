<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Auth;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function login(): JsonResponse
    {
        return $this->success(['userToken' => '1']);
    }
}
