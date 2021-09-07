<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Models\Card as EloquentCard;

class WorkspaceService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function addWorkspace(string $customerId)
    {
        return;
    }

    public function changeProfile(string $customerId)
    {
        return;
    }

}
