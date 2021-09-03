<?php

namespace App\Contexts\Cards\Domain\ReadModel;

use App\Contexts\Cards\Domain\Model\Card\RequirementId;
use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;

final class PlanRequirement
{
    use ArrayPresenterTrait;

    private function __construct(
        private string $requirementId,
        private string $description,
    ) {
    }

    public static function make(string $requirementId, string $description): self
    {
        return new self($requirementId, $description);
    }

    public function getRequirementId(): RequirementId
    {
        return RequirementId::of($this->requirementId);
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
