<?php

namespace App\Contexts\MobileAppBack\Domain\ReadModel\Workspace;

use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;

final class BusinessWorkspace
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $workspaceId,
        public string $keeperId,
        public string $name,
        public string $description,
        public string $address,
    ) {
    }

    #[Pure]
    public static function make(
        string $workspaceId,
        string $keeperId,
        string $name,
        string $description,
        string $address,
    ): self {
        return new self($workspaceId, $keeperId, $name, $description, $address);
    }

}
