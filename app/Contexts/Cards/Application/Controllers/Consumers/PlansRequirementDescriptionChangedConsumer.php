<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Plans\Integration\Events\RequirementChanged as PlansRequirementChanged;
use App\Shared\Contracts\Messaging\IntegrationEventConsumerInterface;
use phpDocumentor\Reflection\Types\Object_;

final class PlansRequirementDescriptionChangedConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardAppService $cardAppService,
    ) {
    }

    public function consumes(): array
    {
        return [
            PlansRequirementChanged::class,
        ];
    }

    public function handle(string $event): void
    {
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            return;
        }
        $issuedCards = $this->issuedCardReadStorage->allForPlanId($payload->planId);
        foreach ($issuedCards as $issuedCard) {
            $this->cardAppService->fixAchievementDescription(
                $issuedCard->cardId,
                $payload->requirementId,
                $payload->description,
            );
        }
    }
}
