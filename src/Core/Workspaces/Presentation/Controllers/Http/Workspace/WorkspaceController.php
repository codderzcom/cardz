<?php

namespace Cardz\Core\Workspaces\Presentation\Controllers\Http\Workspace;

use Cardz\Core\Workspaces\Presentation\Controllers\Http\BaseController;
use Cardz\Core\Workspaces\Presentation\Controllers\Http\Workspace\Commands\{AddWorkspaceRequest, ChangeWorkspaceProfileRequest};
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function add(AddWorkspaceRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response($command->getWorkspaceId());
    }

    public function changeProfile(ChangeWorkspaceProfileRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response($command->getWorkspaceId());
    }
}
