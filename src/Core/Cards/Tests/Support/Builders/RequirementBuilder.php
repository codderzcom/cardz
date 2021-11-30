<?php

namespace Cardz\Core\Cards\Tests\Support\Builders;

use Cardz\Core\Cards\Domain\Model\Plan\Requirement;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class RequirementBuilder extends BaseBuilder
{
    public string $requirementId;

    public string $description;

    public function build(): Requirement
    {
        return Requirement::of($this->requirementId, $this->description);
    }

    public function generate(): static
    {
        $this->requirementId = GuidBasedImmutableId::makeValue();
        $this->description = $this->faker->text(50);
        return $this;
    }

    /**
     * @return Requirement[]
     */
    public static function generateSeries(int $quantity = 5): array
    {
        $requirements = [];
        for ($i = 0; $i < $quantity; $i++) {
            $requirements[] = self::make()->build();
        }
        return $requirements;
    }
}
