<?php

namespace App\Contexts\MobileAppBack\Domain\ReadModel\Customer;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;

final class CustomerWorkspace
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $workspaceId,
        public string $name,
        public string $description,
        public string $address,
    ) {
    }

    #[Pure]
    public static function make(
        string $workspaceId,
        string $name,
        string $description,
        string $address,
    ): self {
        return new self($workspaceId, $name, $description, $address);
    }

}
