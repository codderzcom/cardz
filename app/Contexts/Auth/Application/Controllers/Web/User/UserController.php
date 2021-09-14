<?php

namespace App\Contexts\Auth\Application\Controllers\Web\User;

use App\Contexts\Auth\Application\Controllers\Web\BaseController;
use App\Contexts\Auth\Application\Controllers\Web\User\Commands\RegisterUserRequest;
use App\Contexts\Auth\Application\Services\UserAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User as EloquentUser;

class UserController extends BaseController
{
    public function __construct(
        private UserAppService $userAppService,
    ) {
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $result = $this->userAppService->register(
            $request->name,
            $request->password,
            $request->email,
            $request->phone,
        );
        if ($result->isOk()) {
            Auth::login(EloquentUser::query()->find((string) $result->getPayload()->userId));
        }
        return $this->response($result);
    }
}
