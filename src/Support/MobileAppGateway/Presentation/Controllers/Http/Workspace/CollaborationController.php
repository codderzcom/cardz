<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use Cardz\Support\MobileAppGateway\Application\Services\Workspace\CollaborationAppService;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration\InviteRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration\LeaveCollaborationRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration\ProposeInviteRequest;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CollaborationController extends BaseController
{
    public function __construct(
        private CollaborationAppService $collaborationAppService,
    ) {
    }

    /**
     * Propose invite
     *
     * Returns id of the new invite to collaborate on the workspace.
     * Requires user to be the owner of the current workspace.
     */
    #[OpenApi\Operation(tags: ['business', 'collaboration'])]
    public function propose(ProposeInviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->propose($request->collaboratorId, $request->workspaceId));
    }

    /**
     * Accept invite
     *
     * Accepts an invitation to collaborate. Authorizes user to work in the current workspace.
     */
    #[OpenApi\Operation(tags: ['business', 'collaboration'])]
    public function accept(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->accept($request->collaboratorId, $request->inviteId));
    }

    /**
     * Discard invite
     *
     * Returns id of the new invite to collaborate on the workspace.
     * Requires user to be the owner of the current workspace.
     */
    #[OpenApi\Operation(tags: ['business', 'collaboration'])]
    public function discard(InviteRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->discard($request->inviteId));
    }

    /**
     * Leave collaboration
     *
     * Rescinds the user ability collaborate in the current workspace.
     * Requires user to be authorized to work in the current workspace. Requires user to NOT be the owner of it.
     */
    public function leave(LeaveCollaborationRequest $request): JsonResponse
    {
        return $this->response($this->collaborationAppService->leave($request->collaboratorId, $request->workspaceId));
    }
}
