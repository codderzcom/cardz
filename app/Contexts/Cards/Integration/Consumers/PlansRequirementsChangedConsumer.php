<?php

namespace App\Contexts\Cards\Integration\Consumers;

use App\Contexts\Cards\Application\Commands\AcceptRequirements;
use App\Contexts\Cards\Domain\Model\Plan\Requirement;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Plans\Integration\Events\PlanRequirementsChanged as PlansPlanRequirementsChanged;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\IntegrationEventConsumerInterface;

final class PlansRequirementsChangedConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CommandBusInterface $commandBus,
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
        $requirements = $this->mapRequirements($payload->requirements);

        foreach ($issuedCards as $issuedCard) {
            $command = AcceptRequirements::of($issuedCard->cardId, ...$requirements);
            $this->commandBus->dispatch($command);
        }
    }

    /**
     * @return Requirement[]
     */
    private function mapRequirements(array $eventRequirements): array
    {
        $requirements = [];
        foreach ($eventRequirements as $eventRequirement) {
            $requirements[] = Requirement::of(
                $eventRequirement->requirementId,
                $eventRequirement->description,
            );
        }
        return $requirements;
    }
}
