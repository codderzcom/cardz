<?php

namespace App\Contexts\Cards\Integration\Consumers;

use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Cards\Domain\ReadModel\ReadRequirement;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Plans\Integration\Events\PlanRequirementsChanged as PlansPlanRequirementsChanged;
use App\Shared\Contracts\Messaging\IntegrationEventConsumerInterface;
use Generator;

final class PlansRequirementsChangedConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardAppService $cardAppService,
    ) {
    }

    public function consumes(): array
    {
        return [
            PlansPlanRequirementsChanged::class,
        ];
    }

    public function handle(string $event): void
    {
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            return;
        }

        $issuedCards = $this->issuedCardReadStorage->allForPlanId($payload->planId);

        /** @var ReadRequirement[] $requirements */
        $requirements = $this->mapRequirements($payload->requirements);

        foreach ($issuedCards as $issuedCard) {
            $this->cardAppService->acceptRequirements($issuedCard->cardId, ...$requirements);
        }
    }

    private function mapRequirements(array $eventRequirements): Generator
    {
        foreach ($eventRequirements as $eventRequirement) {
            yield new ReadRequirement(
                $eventRequirement->requirementId,
                $eventRequirement->planId,
                $eventRequirement->description,
            );
        }
    }

}
