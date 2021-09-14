<?php

namespace App\Contexts\Auth\Application\Controllers\Consumers;

use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Auth\Application\IntegrationEvents\UserNameProvided;
use App\Contexts\Auth\Application\IntegrationEvents\RegistrationCompleted;

final class UserNameProvidedConsumer implements Informable
{
    public function __construct(private ReportingBusInterface $reportingBus)
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof UserNameProvided;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var UserNameProvided $event */
        $event = $reportable;
        $this->reportingBus->report(new RegistrationCompleted($reportable->getInstanceId()));
    }

}
