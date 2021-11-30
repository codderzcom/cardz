<?php

namespace Cardz\Support\MobileAppGateway\Integration\Contracts;

interface WorkspacesContextInterface
{
    public function add(string $keeperId, string $name, string $description, string $address): string;

    public function changeProfile(string $workspaceId, string $name, string $description, string $address): string;
}
