<?php

namespace Cardz\Core\Plans\Application\Consumers;

use Cardz\Core\Plans\Domain\Events\Requirement\RequirementChanged as DomainRequirementChanged;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts\ReadRequirementStorageInterface;
use Cardz\Core\Plans\Integration\Events\RequirementChanged;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

final class RequirementChangedDomainEventsConsumer implements EventConsumerInterface
{

    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
        private ReadRequirementStorageInterface $readRequirementStorage,
    ) {
    }

    public function consumes(): array
    {
        return [
            DomainRequirementChanged::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        if (!$event instanceof DomainRequirementChanged) {
            return;
        }

        $requirement = $this->readRequirementStorage->take($event->with()?->requirementId);
        if ($requirement !== null) {
            $this->integrationEventBus->publish(RequirementChanged::of($requirement));
        }
    }

}
