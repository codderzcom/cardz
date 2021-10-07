<?php

namespace App\Contexts\Plans\Application\Commands\Requirement;

use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;

final class RemoveRequirement implements RemoveRequirementCommandInterface
{
    private function __construct(
        private string $requirementId,
    ) {
    }

    public static function of(string $requirementId): self
    {
        return new self($requirementId);
    }

    public function getRequirementId(): RequirementId
    {
        return RequirementId::of($this->requirementId);
    }

}
