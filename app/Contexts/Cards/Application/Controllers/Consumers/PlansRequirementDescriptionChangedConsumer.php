<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Plans\Integration\Events\RequirementChanged as PlansRequirementChanged;
use App\Models\Requirement as EloquentRequirement;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;

final class PlansRequirementDescriptionChangedConsumer implements Informable
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardAppService $cardAppService,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        //ToDo: InterContext dependency.
        return $reportable instanceof PlansRequirementChanged;
    }

    //ToDo: Идёт как системный фикс в обход агрегата. ХЗ, правильно ли.
    public function inform(Reportable $reportable): void
    {
        /** @var PlansRequirementChanged $event */
        $event = $reportable;
        $requirementId = $event->id();
        $eloquentRequirement = EloquentRequirement::query()->find($requirementId);
        if ($eloquentRequirement === null) {
            return;
        }
        $issuedCards = $this->issuedCardReadStorage->allForPlanId($eloquentRequirement->plan_id);
        foreach ($issuedCards as $issuedCard) {
            $this->cardAppService->fixAchievementDescription(
                $issuedCard->cardId,
                $eloquentRequirement->id,
                $eloquentRequirement->description
            );
        }
    }
}
