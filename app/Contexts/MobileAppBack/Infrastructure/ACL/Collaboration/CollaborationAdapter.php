<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Collaboration;

use App\Contexts\Collaboration\Application\Services\InviteAppService;
use App\Contexts\Collaboration\Application\Services\KeeperAppService;
use App\Contexts\Collaboration\Application\Services\RelationAppService;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class CollaborationAdapter
{
    //ToDo: здесь могло бы быть обращение по HTTP
    public function __construct(
        private InviteAppService $inviteAppService,
        private KeeperAppService $keeperAppService,
        private RelationAppService $relationAppService,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function propose(string $keeperId, string $memberId, string $workspaceId): ServiceResultInterface
    {
        return $this->keeperAppService->invite($keeperId, $memberId, $workspaceId);
    }

    public function accept(string $inviteId): ServiceResultInterface
    {
        return $this->inviteAppService->accept($inviteId);
    }

    public function reject(string $inviteId): ServiceResultInterface
    {
        return $this->inviteAppService->reject($inviteId);
    }

    public function discard(string $inviteId): ServiceResultInterface
    {
        return $this->inviteAppService->discard($inviteId);
    }

    public function leave(string $relationId): ServiceResultInterface
    {
        return $this->relationAppService->leave($relationId);
    }
}
