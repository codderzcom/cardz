<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Plans\Application\IntegrationEvents\RequirementChanged as PlansRequirementChanged;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Models\Card as EloquentCard;
use App\Models\Requirement as EloquentRequirement;

final class PlansRequirementDescriptionChangedConsumer implements Informable
{
    public function __construct()
    {
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
        $requirement = EloquentRequirement::query()->find($requirementId);
        if ($requirement === null) {
            return;
        }
        /** @var EloquentCard[] $cards */
        $cards = EloquentCard::query()->where('plan_id', '=', $requirement->plan_id)->get();
        foreach ($cards as $card) {
            foreach ($card->achievements as $achievement) {
                if ($achievement[0] === $requirementId) {
                    $achievement[1] = $requirement->description;
                }
            }
            foreach ($card->requirements as $requirements) {
                if ($requirements[0] === $requirementId) {
                    $requirements[1] = $requirement->description;
                }
            }
            $card->save();
        }
    }
}
