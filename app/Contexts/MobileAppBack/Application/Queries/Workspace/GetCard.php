<?php

namespace App\Contexts\MobileAppBack\Application\Queries\Workspace;

use App\Shared\Contracts\Queries\QueryInterface;

final class GetCard implements QueryInterface
{
    private function __construct(
        public string $keeperId,
        public string $workspaceId,
        public string $cardId,
    ) {
    }

    public static function of(string $keeperId, string $workspaceId, string $cardId): self
    {
        return new self($keeperId, $workspaceId, $cardId);
    }
}
