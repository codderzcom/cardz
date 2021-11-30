<?php

namespace Cardz\Core\Cards\Integration\Consumers;

use Cardz\Core\Cards\Application\Commands\FixAchievementDescription;
use Cardz\Core\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use Cardz\Core\Plans\Integration\Events\RequirementChanged as PlansRequirementChanged;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

final class PlansRequirementDescriptionChangedConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CommandBusInterface $commandBus,
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
            $command = FixAchievementDescription::of($issuedCard->cardId, $payload->requirementId, $payload->description);
            $this->commandBus->dispatch($command);
        }
    }
}
