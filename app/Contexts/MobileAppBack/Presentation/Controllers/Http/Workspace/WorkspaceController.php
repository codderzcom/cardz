<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\Authorization\Dictionary\ObjectTypeRepository;
use App\Contexts\Authorization\Dictionary\PermissionRepository;
use App\Contexts\MobileAppBack\Application\Services\AuthorizationServiceInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\WorkspaceAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\AddWorkspaceRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\ChangeWorkspaceProfileRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetWorkspaceRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\CollaboratorQueryRequest;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private WorkspaceAppService $workspaceService,
        private AuthorizationServiceInterface $authorizationService,
    ) {
    }

    public function getWorkspaces(CollaboratorQueryRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->getBusinessWorkspaces(
            $request->collaboratorId,
        ));
    }

    public function getWorkspace(GetWorkspaceRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            PermissionRepository::WORKSPACES_VIEW(),
            ObjectTypeRepository::WORKSPACE(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->workspaceService->getBusinessWorkspace(
            $request->collaboratorId,
            $request->workspaceId,
        ));
    }

    public function addWorkspace(AddWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->addWorkspace(
            $request->keeperId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }

    public function changeWorkspaceProfile(ChangeWorkspaceProfileRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            PermissionRepository::WORKSPACES_CHANGE_PROFILE(),
            ObjectTypeRepository::WORKSPACE(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->workspaceService->changeProfile(
            $request->collaboratorId,
            $request->workspaceId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }
}
