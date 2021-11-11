<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Invite;

use App\Contexts\Collaboration\Presentation\Controllers\Http\BaseController;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands\AcceptInviteRequest;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands\DiscardInviteRequest;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands\ProposeInviteRequest;
use App\Shared\Contracts\Commands\CommandBusInterface;
use Illuminate\Http\JsonResponse;

class InviteController extends BaseController
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function propose(ProposeInviteRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response($command->getInviteId());
    }

    public function accept(AcceptInviteRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response($command->getInviteId());
    }

    public function discard(DiscardInviteRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response($command->getInviteId());
    }
}
