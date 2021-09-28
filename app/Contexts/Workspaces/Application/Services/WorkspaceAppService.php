<?php

namespace App\Contexts\Workspaces\Application\Services;

use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Integration\Events\WorkspaceAdded;
use App\Contexts\Workspaces\Integration\Events\WorkspaceProfileChanged;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class WorkspaceAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function add(string $keeperId, string $name, string $description, string $address): ServiceResultInterface
    {
        $keeper = $this->keeperRepository->take(KeeperId::of($keeperId));
        if ($keeper === null) {
            return $this->serviceResultFactory->notFound("Keeper $keeperId not found");
        }

        $workspaceId = WorkspaceId::make();
        $workspace = $keeper->keepWorkspace($workspaceId, $name, $description, $address);
        $this->workspaceRepository->persist($workspace);

        $result = $this->serviceResultFactory->ok($workspace, new WorkspaceAdded($workspaceId)); //ToDo: added on domain profile filled.
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
