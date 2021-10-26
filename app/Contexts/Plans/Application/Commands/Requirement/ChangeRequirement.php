<?php

namespace App\Contexts\Plans\Application\Commands\Requirement;

use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;

final class ChangeRequirement implements RequirementCommandInterface
{
    private function __construct(
        private string $requirementId,
        private string $description,
    ) {
    }

    public static function of(string $requirementId, string $description): self
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
