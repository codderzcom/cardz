<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Workspaces;

use App\Contexts\Workspaces\Application\Services\WorkspaceAppService;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class WorkspacesAdapter
{
    //ToDo: здесь могло бы быть обращение по HTTP
    public function __construct(
        private WorkspaceAppService $workspaceAppService,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function addWorkspace(string $keeperId, string $name, string $description, string $address): ServiceResultInterface
    {
        $result = $this->workspaceAppService->add($keeperId, $name, $description, $address);
        if ($result->isNotOk()){
            return $result;
        }
        $workspaceId = (string) $result->getPayload()->workspaceId;
        return $this->serviceResultFactory->ok($workspaceId);
    }

    public function changeProfile(string $workspaceId, string $name, string $description, string $address): ServiceResultInterface
    {
        $result = $this->workspaceAppService->changeProfile($workspaceId, $name, $description, $address);
        if ($result->isNotOk()){
            return $result;
        }
        $workspaceId = (string) $result->getPayload()->workspaceId;
        return $this->serviceResultFactory->ok($workspaceId);
    }


}
