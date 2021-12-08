<?php

namespace Cardz\Core\Workspaces\Application\Commands;

use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

final class RegisterKeeper implements CommandInterface
{
    private function __construct(
        private string $keeperId,
    ) {
    }

    public static function of(string $keeperId): self
    {
        return new self(KeeperId::of($keeperId));
    }

    public function getKeeperId(): KeeperId
    {
        return KeeperId::of($this->keeperId);
    }

}
