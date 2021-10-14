<?php

namespace App\Contexts\Auth\Application\Controllers\Consumers;

use App\Contexts\Auth\Integration\Events\RegistrationCompleted;
use App\Contexts\Auth\Integration\Events\UserNameProvided;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;
use App\Shared\Contracts\ReportingBusInterface;

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
        $this->reportingBus->report(new RegistrationCompleted($event->id()));
    }

}
