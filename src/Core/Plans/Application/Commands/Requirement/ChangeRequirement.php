<?php

namespace Cardz\Core\Plans\Application\Commands\Requirement;

use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;
use JetBrains\PhpStorm\Pure;

final class ChangeRequirement implements RequirementCommandInterface
{
    private function __construct(
        private string $requirementId,
        private string $description,
    ) {
    }

    #[Pure]
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
