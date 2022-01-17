<?php

namespace Cardz\Core\Plans\Application\Commands\Requirement;

use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;
use JetBrains\PhpStorm\Pure;

final class RemoveRequirement implements RequirementCommandInterface
{
    private function __construct(
        private string $requirementId,
    ) {
    }

    #[Pure]
    public static function of(string $requirementId): self
    {
        return new self($requirementId);
    }

    public function getRequirementId(): RequirementId
    {
        return RequirementId::of($this->requirementId);
    }

}
