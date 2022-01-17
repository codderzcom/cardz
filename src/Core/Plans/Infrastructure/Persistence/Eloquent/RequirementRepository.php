<?php

namespace Cardz\Core\Plans\Infrastructure\Persistence\Eloquent;

use App\Models\Requirement as EloquentRequirement;
use Carbon\Carbon;
use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Exceptions\RequirementNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;
use JetBrains\PhpStorm\ArrayShape;

class RequirementRepository implements RequirementRepositoryInterface
{

    use PropertiesExtractorTrait;

    public function persist(Requirement $requirement): void
    {
        EloquentRequirement::query()->updateOrCreate(
            ['id' => $requirement->requirementId],
            $this->requirementAsData($requirement)
        );
    }

    public function take(RequirementId $requirementId): Requirement
    {
        /** @var EloquentRequirement $eloquentRequirement */
        $eloquentRequirement = EloquentRequirement::query()->find((string) $requirementId);
        if ($eloquentRequirement === null) {
            throw new RequirementNotFoundException((string) $requirementId);
        }
        return $this->requirementFromData($eloquentRequirement);
    }

    #[ArrayShape([
        'id' => "string",
        'plan_id' => "string",
        'description' => "string",
        'added_at' => Carbon::class | null,
        'removed_at' => Carbon::class | null,
    ])]
    private function requirementAsData(Requirement $requirement): array
    {
        $properties = $this->extractProperties($requirement, 'added', 'removed');
        return [
            'id' => (string) $requirement->requirementId,
            'plan_id' => (string) $requirement->planId,
            'description' => $requirement->getDescription(),
            'added_at' => $properties['added'],
            'removed_at' => $properties['removed'],
        ];
    }

    private function requirementFromData(EloquentRequirement $eloquentRequirement): Requirement
    {
        return Requirement::restore(
            $eloquentRequirement->id,
            $eloquentRequirement->plan_id,
            $eloquentRequirement->description,
            $eloquentRequirement->added_at,
            $eloquentRequirement->removed_at,
        );
    }
}
