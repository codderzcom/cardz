<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Cardz\Support\MobileAppGateway\Application\Services\AuthorizationServiceInterface;
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
        private AuthorizationServiceInterface $authorizationService,
    ) {
    }

    public function propose(ProposeInviteRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::INVITE_PROPOSE(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->collaborationAppService->propose($request->collaboratorId, $request->workspaceId));
    }

    public function accept(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->accept($request->collaboratorId, $request->inviteId));
    }

    public function discard(InviteRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::INVITE_DISCARD(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->collaborationAppService->discard($request->inviteId));
    }

    public function leave(LeaveCollaborationRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::COLLABORATION_LEAVE(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->collaborationAppService->leave($request->collaboratorId, $request->workspaceId));
    }
}
