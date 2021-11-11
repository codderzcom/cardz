<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Requirement;

use App\Contexts\Plans\Presentation\Controllers\Http\BaseController;
use App\Contexts\Plans\Presentation\Controllers\Http\Requirement\Commands\{AddRequirementRequest, ChangeRequirementRequest, RemoveRequirementRequest};
use App\Shared\Contracts\Commands\CommandBusInterface;
use Illuminate\Http\JsonResponse;

class RequirementController extends BaseController
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function add(AddRequirementRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response($command->getRequirementId());
    }

    public function remove(RemoveRequirementRequest $request): JsonResponse
    {
        $this->commandBus->dispatch($request->toCommand());
        return $this->response($request->getRequirementId());
    }

    public function change(ChangeRequirementRequest $request): JsonResponse
    {
        $this->commandBus->dispatch($request->toCommand());
        return $this->response($request->getRequirementId());
    }

}
