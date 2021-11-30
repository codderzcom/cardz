<?php

namespace Cardz\Generic\Authorization\Infrastructure\ObjectProviders;

use App\Models\Card;
use App\Models\Plan;

final class CardProvider extends BaseConcreteObjectProvider
{
    use EloquentProviderTrait, RelationTrait;

    protected function getAttributes(): array
    {
        $card = $this->getEloquentModel(Card::query(), $this->objectId);
        $plan = $this->getEloquentModel(Plan::query(), $card->plan_id);
        $relations = $this->getRelations($plan->workspace_id);
        return [
            'objectId' => $this->objectId,
            'ownerId' => $card->customer_id,
            'planId' => $plan->id,
            'workspaceId' => $plan->id,
            'keeperId' => $this->getKeeperId($relations),
            'memberIds' => $this->getMemberIds($relations),
            'isCompleted' => $card->completed_at !== null,
            'isSatisfied' => $card->satisfied_at !== null,
            'isActive' =>
                $plan->launched_at !== null
                && $plan->stopped_at === null
                && $plan->archived_at === null
                && $card->blocked_at === null
                && $card->revoked_at === null
            ,
        ];
    }
}
