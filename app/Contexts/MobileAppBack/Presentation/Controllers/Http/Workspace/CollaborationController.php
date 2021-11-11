<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\Authorization\Dictionary\ObjectTypeRepository;
use App\Contexts\Authorization\Dictionary\PermissionRepository;
use App\Contexts\MobileAppBack\Application\Services\AuthorizationServiceInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\CollaborationAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collaboration\InviteRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collaboration\LeaveCollaborationRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collaboration\ProposeInviteRequest;
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
            PermissionRepository::INVITES_PROPOSE(),
            ObjectTypeRepository::WORKSPACE(),
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
            PermissionRepository::INVITES_DISCARD(),
            ObjectTypeRepository::WORKSPACE(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->collaborationAppService->discard($request->inviteId));
    }

    public function leave(LeaveCollaborationRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            PermissionRepository::COLLABORATION_LEAVE(),
            ObjectTypeRepository::WORKSPACE(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->collaborationAppService->leave($request->collaboratorId, $request->workspaceId));
    }
}
