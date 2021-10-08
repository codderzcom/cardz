<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Cards\Integration\Events\AchievementNoted;
use App\Contexts\Cards\Integration\Events\CardIssued;
use App\Contexts\Cards\Integration\Events\RequirementsAccepted;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;

final class SatisfactionCheckRequiredConsumer implements Informable
{
    public function __construct(
        private CardAppService $cardAppService,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof RequirementsAccepted
            || $reportable instanceof AchievementNoted
            || $reportable instanceof CardIssued;
    }

    //ToDo: для Eventual Consistency что-то другое придётся изобретать
    public function inform(Reportable $reportable): void
    {
        $event = $reportable;
        $this->cardAppService->checkSatisfaction($event->id());
    }

}
