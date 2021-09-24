<?php

namespace App\Contexts\Collaboration\Application\Controllers\Web\Invite;

use App\Contexts\Collaboration\Application\Controllers\Web\BaseController;
use App\Contexts\Collaboration\Application\Controllers\Web\Invite\Commands\InviteProposeRequest;
use App\Contexts\Collaboration\Application\Controllers\Web\Invite\Commands\InviteRequest;
use App\Contexts\Collaboration\Application\Services\InviteAppService;
use Illuminate\Http\JsonResponse;

class InviteController extends BaseController
{
    public function __construct(
        private InviteAppService $inviteAppService,
    ) {
    }

    public function propose(InviteProposeRequest $request): JsonResponse
    {
        return $this->response($this->inviteAppService->propose(
            $request->collaboratorId,
            $request->workspaceId,
        ));
    }

    public function accept(InviteRequest $request): JsonResponse
    {
        return $this->response($this->inviteAppService->accept(
            $request->inviteId,
        ));
    }

    public function reject(InviteRequest $request): JsonResponse
    {
        return $this->response($this->inviteAppService->reject(
            $request->inviteId,
        ));
    }

    public function discard(InviteRequest $request): JsonResponse
    {
        return $this->response($this->inviteAppService->discard(
            $request->inviteId,
        ));
    }
}
