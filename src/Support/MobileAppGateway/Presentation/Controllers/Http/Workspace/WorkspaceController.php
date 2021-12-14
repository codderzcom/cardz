<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use App\OpenApi\Requests\Customer\AddWorkspaceRequestBody;
use App\OpenApi\Requests\Customer\ChangeWorkspaceProfileRequestBody;
use App\OpenApi\Responses\BusinessWorkspaceResponse;
use App\OpenApi\Responses\BusinessWorkspacesResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Cardz\Support\MobileAppGateway\Application\Services\Workspace\WorkspaceAppService;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\AddWorkspaceRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\ChangeWorkspaceProfileRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\CollaboratorQueryRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\GetWorkspaceRequest;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class WorkspaceController extends BaseController
{
    public function __construct(
        private WorkspaceAppService $workspaceService,
    ) {
    }

    /**
     * Get workspaces
     *
     * Returns all workspaces where the current user is a collaborator.
     */
    #[OpenApi\Operation(tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: BusinessWorkspacesResponse::class, statusCode: 200)]
    public function getWorkspaces(CollaboratorQueryRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->getBusinessWorkspaces($request->collaboratorId));
    }

    /**
     * Get a workspace
     *
     * Returns workspace where the current user is a collaborator.
     * Requires user to be authorized to work in this workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: BusinessWorkspaceResponse::class, statusCode: 200)]
    public function getWorkspace(GetWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->getBusinessWorkspace($request->workspaceId));
    }

    /**
     * Add a new workspace
     *
     * Returns the newly created workspace where the current user is an owner.
     */
    #[OpenApi\Operation(tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\RequestBody(factory: AddWorkspaceRequestBody::class)]
    #[OpenApi\Response(factory: BusinessWorkspaceResponse::class, statusCode: 200)]
    public function addWorkspace(AddWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->addWorkspace(
            $request->keeperId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }

    /**
     * Change workspace description
     *
     * Changes the current workspace description.
     * Requires user to be the owner of the current workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\RequestBody(factory: ChangeWorkspaceProfileRequestBody::class)]
    #[OpenApi\Response(factory: BusinessWorkspaceResponse::class, statusCode: 200)]
    public function changeWorkspaceProfile(ChangeWorkspaceProfileRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->changeProfile(
            $request->workspaceId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }
}
