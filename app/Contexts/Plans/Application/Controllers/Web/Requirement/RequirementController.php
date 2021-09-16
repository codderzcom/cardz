<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Requirement;

use App\Contexts\Plans\Application\Controllers\Web\BaseController;
use App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands\{AddRequirementRequest, ChangeRequirementRequest, RemoveRequirementRequest};
use App\Contexts\Plans\Application\Services\RequirementAppService;
use Illuminate\Http\JsonResponse;

class RequirementController extends BaseController
{
    public function __construct(
        private RequirementAppService $requirementAppService,
    ) {
    }

    public function addRequirement(AddRequirementRequest $request): JsonResponse
    {
        return $this->response($this->requirementAppService->add(
            $request->planId,
            $request->description,
        ));
    }

    public function removeRequirement(RemoveRequirementRequest $request): JsonResponse
    {
        return $this->response($this->requirementAppService->remove(
            $request->planId,
            $request->requirementId,
        ));
    }

    public function changeRequirement(ChangeRequirementRequest $request): JsonResponse
    {
        return $this->response($this->requirementAppService->change(
            $request->planId,
            $request->requirementId,
            $request->description,
        ));
    }

}
