<?php

namespace App\Contexts\Workspaces\Application\Controllers\Web\Workspace;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Workspaces\Application\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Application\Controllers\Web\BaseController;
use App\Contexts\Workspaces\Application\Controllers\Web\Workspace\Commands\AddWorkspaceRequest;
use App\Contexts\Workspaces\Application\Controllers\Web\Workspace\Commands\ChangeWorkspaceProfileRequest;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceAdded;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceProfileChanged;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepository,
        ReportingBusInterface $reportingBus
    ) {
        parent::__construct($reportingBus);
    }

    public function add(AddWorkspaceRequest $request): JsonResponse
    {
        $workspace = Workspace::create(
            $request->workspaceId,
            $request->profile,
        );
        $workspace?->add();
        $this->workspaceRepository->persist($workspace);
        return $this->success(new WorkspaceAdded($request->workspaceId, 'Workspace'));
    }

    public function changeProfile(ChangeWorkspaceProfileRequest $request): JsonResponse
    {
        $workspace = $this->workspaceRepository->take($request->workspaceId);
        dd($workspace);
        $workspace?->changeProfile($request->profile);
        $this->workspaceRepository->persist($workspace);
        return $this->success(new WorkspaceProfileChanged($request->workspaceId, 'Workspace'));
    }
}
