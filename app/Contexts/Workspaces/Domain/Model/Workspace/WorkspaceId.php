<?php

namespace App\Contexts\Workspaces\Domain\Model\Workspace;

use Ramsey\Uuid\Guid\Guid;

class WorkspaceId
{
    public function __construct(private ?string $id = null)
    {
        if ($this->id === null) {
            $this->id = (string) Guid::uuid4();
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
