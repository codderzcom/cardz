<?php

namespace App\Contexts\Workspaces\Application\Services;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;
use App\Contexts\Workspaces\Application\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceAdded;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceProfileChanged;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;

class WorkspaceAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function add(string $keeperId, string $name, string $description, string $address): ServiceResultInterface
    {
        $workspace = Workspace::make(
            WorkspaceId::make(),
            KeeperId::of($keeperId),
            Profile::of($name, $description, $address),
        );

        $workspace->add();
        $this->workspaceRepository->persist($workspace);

        $result = $this->serviceResultFactory->ok($workspace, new WorkspaceAdded($workspace->workspaceId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function changeProfile(string $workspaceId, string $name, string $description, string $address): ServiceResultInterface
    {
        $workspace = $this->workspaceRepository->take(WorkspaceId::of($workspaceId));
        if ($workspace === null) {
            return $this->serviceResultFactory->notFound("Workspace $workspaceId not found");
        }

        $workspace->changeProfile(Profile::of($name, $description, $address));
        $this->workspaceRepository->persist($workspace);

        $result = $this->serviceResultFactory->ok($workspace, new WorkspaceProfileChanged($workspace->workspaceId));
        return $this->reportResult($result, $this->reportingBus);
    }

}
