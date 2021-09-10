<?php

namespace App\Contexts\Personal\Application\Controllers\Web\Person;

use App\Contexts\Personal\Application\Controllers\Web\BaseController;
use App\Contexts\Personal\Application\Controllers\Web\Person\Commands\ChangePersonNameRequest;
use App\Contexts\Personal\Application\Controllers\Web\Person\Commands\JoinPersonRequest;
use App\Contexts\Personal\Application\Services\PersonAppService;
use Illuminate\Http\JsonResponse;

class PersonController extends BaseController
{
    public function __construct(
        private PersonAppService $personAppService
    ) {
    }

    public function join(JoinPersonRequest $request): JsonResponse
    {
        return $this->response($this->personAppService->join(
            $request->personId,
            $request->name,
        ));
    }

    public function changeName(ChangePersonNameRequest $request): JsonResponse
    {
        return $this->response($this->personAppService->changeName(
            $request->personId,
            $request->name,
        ));
    }
}
