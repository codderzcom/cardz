<?php

namespace App\Contexts\Plans\Infrastructure\Persistence;

use App\Contexts\Plans\Application\Contracts\AchievementRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use App\Models\Achievement as EloquentAchievement;
use ReflectionClass;

class AchievementRepository implements AchievementRepositoryInterface
{
    public function persist(?Achievement $achievement): void
    {
        if ($achievement === null) {
            return;
        }

        EloquentAchievement::query()->updateOrCreate(
            ['id' => $achievement->achievementId],
            $this->achievementAsData($achievement)
        );
    }

    private function achievementAsData(Achievement $achievement): array
    {
        $reflection = new ReflectionClass($achievement);
        $properties = [
            'added' => null,
            'removed' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($achievement);
        }

        $data = [
            'id' => (string) $achievement->achievementId,
            'plan_id' => (string) $achievement->planId,
            'description' => $achievement->getDescription(),
            'added_at' => $properties['added'],
            'removed_at' => $properties['removed'],
        ];
        return $data;
    }

    public function take(AchievementId $achievementId): ?Achievement
    {
        if ($achievementId === null) {
            return null;
        }
        /** @var EloquentAchievement $eloquentAchievement */
        $eloquentAchievement = EloquentAchievement::query()->where([
            'id' => (string) $achievementId,
        ])?->first();
        if ($eloquentAchievement === null) {
            return null;
        }
        return $this->achievementFromData($eloquentAchievement);
    }

    private function achievementFromData(EloquentAchievement $eloquentAchievement): Achievement
    {
        $reflection = new ReflectionClass(Achievement::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Achievement $achievement */
        $achievement = $reflection->newInstanceWithoutConstructor();

        $creator?->invoke($achievement,
            $eloquentAchievement->id,
            $eloquentAchievement->plan_id,
            $eloquentAchievement->description,
            $eloquentAchievement->added_at,
            $eloquentAchievement->removed_at,
        );
        return $achievement;
    }
}
