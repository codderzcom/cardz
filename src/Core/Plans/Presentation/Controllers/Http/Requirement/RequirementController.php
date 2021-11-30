<?php

namespace Cardz\Core\Plans\Presentation\Controllers\Http\Requirement;

use Cardz\Core\Plans\Presentation\Controllers\Http\BaseController;
use Cardz\Core\Plans\Presentation\Controllers\Http\Requirement\Commands\{AddRequirementRequest, ChangeRequirementRequest, RemoveRequirementRequest};
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
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
