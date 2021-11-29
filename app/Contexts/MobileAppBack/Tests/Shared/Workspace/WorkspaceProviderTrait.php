<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Workspace;

trait WorkspaceProviderTrait
{
    public function getWorkspace(string $populateWith = 'workspace'): WorkspaceRequestDTO
    {
        return new WorkspaceRequestDTO($populateWith, $populateWith, $populateWith);
    }

    public function getAnotherWorkspace(): WorkspaceRequestDTO
    {
        return $this->getWorkspace('another');
    }
}
