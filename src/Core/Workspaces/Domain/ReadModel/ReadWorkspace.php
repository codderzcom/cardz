<?php

namespace Cardz\Core\Workspaces\Domain\ReadModel;

use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use JsonSerializable;

final class ReadWorkspace implements JsonSerializable
{
    use ArrayPresenterTrait;

    public function __construct(
        public string $workspaceId,
        public string $keeperId,
        public string $name,
        public string $description,
        public string $address,
    ) {
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
