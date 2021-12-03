<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use Cardz\Support\MobileAppGateway\Application\Services\Workspace\CollaborationAppService;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration\InviteRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration\LeaveCollaborationRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration\ProposeInviteRequest;
use Illuminate\Http\JsonResponse;

class CollaborationController extends BaseController
{
    public function __construct(
        private CollaborationAppService $collaborationAppService,
    ) {
    }

    public function propose(ProposeInviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->propose($request->collaboratorId, $request->workspaceId));
    }

    public function accept(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->accept($request->collaboratorId, $request->inviteId));
    }

    public function discard(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->discard($request->inviteId));
    }

    public function leave(LeaveCollaborationRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->leave($request->collaboratorId, $request->workspaceId));
    }
}
