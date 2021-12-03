<?php

namespace Cardz\Core\Plans\Application\Consumers;

use Cardz\Core\Plans\Domain\Events\Plan\PlanAdded as DomainPlanAdded;
use Cardz\Core\Plans\Domain\Events\Plan\PlanArchived as DomainPlanArchived;
use Cardz\Core\Plans\Domain\Events\Plan\PlanDescriptionChanged as DomainPlanDescriptionChanged;
use Cardz\Core\Plans\Domain\Events\Plan\PlanLaunched as DomainPlanLaunched;
use Cardz\Core\Plans\Domain\Events\Plan\PlanStopped as DomainPlanStopped;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementAdded as DomainRequirementAdded;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementRemoved as DomainRequirementRemoved;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use Cardz\Core\Plans\Integration\Events\{PlanAdded, PlanDescriptionChanged, PlanLaunched, PlanRequirementsChanged, PlanStopped};
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

final class PlanDomainEventsConsumer implements EventConsumerInterface
{

    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
        private ReadPlanStorageInterface $readPlanStorage,
    ) {
    }

    public function consumes(): array
    {
        return [
            DomainPlanAdded::class,
            DomainPlanLaunched::class,
            DomainPlanStopped::class,
            DomainPlanDescriptionChanged::class,
            DomainPlanArchived::class,
            DomainRequirementAdded::class,
            DomainRequirementRemoved::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        $plan = $this->readPlanStorage->take((string) $event->with()?->planId);
        if ($plan === null) {
            return;
        }

        $integrationEvent = match (true) {
            $event instanceof DomainPlanAdded => PlanAdded::of($plan),
            $event instanceof DomainPlanLaunched => PlanLaunched::of($plan),
            $event instanceof DomainPlanStopped => PlanStopped::of($plan),
            $event instanceof DomainPlanDescriptionChanged => PlanDescriptionChanged::of($plan),
            $event instanceof DomainRequirementAdded, $event instanceof DomainRequirementRemoved => PlanRequirementsChanged::of($plan),
            default => null,
        };

        if ($integrationEvent !== null) {
            $this->integrationEventBus->publish($integrationEvent);
        }
    }

}
