<?php

namespace Cardz\Core\Cards\Integration\Consumers;

use Cardz\Core\Cards\Application\Commands\AcceptRequirements;
use Cardz\Core\Cards\Domain\Model\Plan\Requirement;
use Cardz\Core\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use Cardz\Core\Plans\Integration\Events\PlanRequirementsChanged as PlansPlanRequirementsChanged;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventPayloadProviderTrait;
use JetBrains\PhpStorm\Pure;
use Throwable;

final class PlansRequirementsChangedConsumer implements IntegrationEventConsumerInterface
{
    use IntegrationEventPayloadProviderTrait;

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
        $payload = $this->getPayloadOrNull($event);
        if ($payload === null) {
            return;
        }

        $issuedCards = $this->issuedCardReadStorage->allForPlanId($payload->planId);
        $requirements = $this->mapRequirements($payload->requirements);

        foreach ($issuedCards as $issuedCard) {
            $command = AcceptRequirements::of($issuedCard->cardId, ...$requirements);
            try {
                $this->commandBus->dispatch($command);
            } catch (Throwable $exception) {
                $this->info($exception->getMessage());
            }
        }
    }

    /**
     * @return Requirement[]
     */
    #[Pure]
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
