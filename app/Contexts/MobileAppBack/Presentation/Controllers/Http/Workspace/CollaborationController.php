<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\MobileAppBack\Application\Services\Workspace\CollaborationAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collab\InviteRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collab\LeaveCollaborationRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collab\ProposeInviteRequest;
use Illuminate\Http\JsonResponse;

class CollaborationController extends BaseController
{
    public function __construct(
        private CollaborationAppService $collaborationAppService,
    ) {
    }

    public function propose(ProposeInviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->propose(
            $request->collaboratorId,
            $request->memberId,
            $request->workspaceId,
        ));
    }

    public function accept(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->accept(
            $request->collaboratorId,
            $request->workspaceId,
            $request->inviteId,
        ));
    }

    public function reject(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->reject(
            $request->collaboratorId,
            $request->workspaceId,
            $request->inviteId,
        ));
    }

    public function discard(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->discard(
            $request->collaboratorId,
            $request->workspaceId,
            $request->inviteId,
        ));
    }

    public function leaveCollaboration(LeaveCollaborationRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->leave(
            $request->collaboratorId,
            $request->workspaceId,
        ));
    }
}
