<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Model\Shared\ValueObject;
use JetBrains\PhpStorm\Pure;

final class Achievement extends ValueObject
{
    private function __construct(
        private RequirementId $requirementId,
        private string $description
    ) {
    }

    #[Pure]
    public static function of(RequirementId $requirementId, string $description): self
    {
        return new self($requirementId, $description);
    }

    public function getRequirementId(): RequirementId
    {
        return $this->requirementId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

