<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Workspace;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;

class PlanRequestDTO
{
    use ArrayPresenterTrait;

    public function __construct(
        public string $description,
    ) {
    }
}
