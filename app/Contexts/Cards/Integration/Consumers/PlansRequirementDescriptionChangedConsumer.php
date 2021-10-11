<?php

namespace App\Contexts\Cards\Integration\Consumers;

use App\Contexts\Cards\Application\Commands\FixAchievementDescription;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Plans\Integration\Events\RequirementChanged as PlansRequirementChanged;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\IntegrationEventConsumerInterface;

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
