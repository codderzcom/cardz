<?php

namespace Cardz\Core\Workspaces\Integration\Events;

use Cardz\Core\Workspaces\Domain\ReadModel\AddedWorkspace;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

abstract class BaseWorkspaceIntegrationEvent implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    protected function __construct(
        protected AddedWorkspace $workspace,
    ) {
    }

    #[Pure]
    public static function of(AddedWorkspace $workspace): static
    {
        return new static($workspace);
    }

    #[ArrayShape(['name' => "string", 'payload' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => $this->workspace->toArray(),
        ];
    }
}
