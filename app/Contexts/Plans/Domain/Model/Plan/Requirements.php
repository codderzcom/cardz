<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use App\Contexts\Plans\Domain\Model\Shared\ValueObject;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Requirements extends ValueObject
{
    private array $requirements;

    private function __construct(Requirement ...$requirements)
    {
        $this->requirements = $requirements;
    }

    #[Pure]
    public static function of(string ...$descriptions): self
    {
        $requirements = [];
        foreach ($descriptions as $description) {
            $requirements[] = Requirement::of($description);
        }
        return new self(...$requirements);
    }

    #[Pure]
    public function copy(): self
    {
        return new self(...$this->requirements);
    }

    #[Pure]
    public function toArray(): array
    {
        $data = [];
        foreach ($this->requirements as $requirement) {
            $data[] = $requirement->getDescription();
        }
        return $data;
    }

    #[Pure]
    public function add(Requirement $requirement): self
    {
        $requirements = $this->requirements;
        $requirements[] = $requirement;
        return new self(...$requirements);
    }

    public function remove(Requirement $requirement): self
    {
        $requirements = $this->requirements;
        foreach ($requirements as $index => $presentRequirement) {
            if ($requirement->equals($presentRequirement)) {
                unset($requirements[$index]);
                break;
            }
        }
        return new self(...$requirements);
    }

    public function filterRemaining(Requirements $requirements): self
    {
        $currentRequirements = $this->requirements;
        foreach ($requirements as $requirement) {
            foreach ($currentRequirements as $index => $currentRequirement) {
                if ($requirement->equals($currentRequirement)) {
                    unset($currentRequirements[$index]);
                    break;
                }
            }
        }
        return new self(...$currentRequirements);
    }

    public function isEmpty(): bool
    {
        return count($this->requirements) === 0;
    }
}
