<?php

namespace App\Contexts\Plans\Integration\Events;

use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Shared\Contracts\Messaging\IntegrationEventInterface;
use App\Shared\Infrastructure\Messaging\IntegrationEventTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class RequirementChanged implements IntegrationEventInterface
{
    use IntegrationEventTrait;

    private function __construct(
        private Requirement $requirement,
    ) {
    }

    #[Pure]
    public static function of(Requirement $requirement): self
    {
        return new self($requirement);
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'payload' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'payload' => [
                'requirementId' => (string) $this->requirement->requirementId,
                'planId' => (string) $this->requirement->planId,
                'description' => $this->requirement->getDescription(),
            ],
        ];
    }

}
