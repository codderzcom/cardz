<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Cards\Infrastructure\ACL\Plans\PlansAdapter;
use App\Contexts\Plans\Application\IntegrationEvents\PlanRequirementsChanged as PlansPlanRequirementsChanged;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;

final class PlansRequirementsChangedConsumer implements Informable
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardAppService $cardAppService,
        private PlansAdapter $plansAdapter,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        //ToDo: InterContext dependency.
        return $reportable instanceof PlansPlanRequirementsChanged;
    }

    //ToDo: для Eventual Consistency что-то другое придётся изобретать
    public function inform(Reportable $reportable): void
    {
        /** @var PlansPlanRequirementsChanged $event */
        $event = $reportable;
        $planId = $event->id();
        $issuedCards = $this->issuedCardReadStorage->allForPlanId($planId);
        $requirements = $this->plansAdapter->getRequirements($planId);
        foreach ($issuedCards as $issuedCard) {
            $this->cardAppService->acceptRequirements($issuedCard->cardId, ...$requirements->getPayload());
        }
    }
}
