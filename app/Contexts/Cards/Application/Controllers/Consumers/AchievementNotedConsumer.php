<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\IntegrationEvents\AchievementNoted;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;

final class AchievementNotedConsumer implements Informable
{
    public function __construct(
        private ReportingBusInterface $reportingBus
    )
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof AchievementNoted;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var AchievementNoted $event */
        $event = $reportable;
    }

}
