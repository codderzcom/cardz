<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Workspace;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;

class WorkspaceRequestDTO
{
    use ArrayPresenterTrait;

    public function __construct(
        public string $name,
        public string $description,
        public string $address,
    ) {
    }
}
