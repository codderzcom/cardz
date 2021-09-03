<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Requirement;

use App\Contexts\Plans\Application\Controllers\Web\BaseController;
use App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands\{RemoveRequirementRequest};
use App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands\AddRequirementRequest;
use App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands\ChangeRequirementRequest;
use App\Contexts\Plans\Application\Services\RequirementAppService;
use Illuminate\Http\JsonResponse;

class RequirementController extends BaseController
{
    public function __construct(
        private RequirementAppService $requirementAppService,
    ) {
    }

    public function add(AddRequirementRequest $request): JsonResponse
    {
        return $this->response($this->requirementAppService->add(
            $request->planId,
            $request->description,
        ));
    }

    public function remove(RemoveRequirementRequest $request): JsonResponse
    {
        return $this->response($this->requirementAppService->remove(
            $request->requirementId,
        ));
    }

    public function change(ChangeRequirementRequest $request): JsonResponse
    {
        return $this->response($this->requirementAppService->change(
            $request->requirementId,
            $request->description,
        ));
    }

}
