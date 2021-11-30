<?php

namespace Cardz\Core\Plans\Application\Commands\Requirement;

use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;

final class RemoveRequirement implements RequirementCommandInterface
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
