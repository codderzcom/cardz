<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Invite;

use App\Contexts\Collaboration\Application\Services\InviteAppService;
use App\Contexts\Collaboration\Application\Services\KeeperAppService;
use App\Contexts\Collaboration\Presentation\Controllers\Http\BaseController;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands\InviteProposeRequest;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands\InviteRequest;
use Illuminate\Http\JsonResponse;

class InviteController extends BaseController
{
    public function __construct(
        private KeeperAppService $keeperAppService,
        private InviteAppService $inviteAppService,
    ) {
    }

    public function propose(InviteProposeRequest $request): JsonResponse
    {
        return $this->response($this->keeperAppService->invite(
            $request->keeperId,
            $request->memberId,
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
