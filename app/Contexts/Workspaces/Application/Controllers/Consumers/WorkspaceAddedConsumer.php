<?php

namespace App\Contexts\Workspaces\Application\Controllers\Consumers;

use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceAdded;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceProfileFilled;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;
use App\Shared\Contracts\ReportingBusInterface;

class WorkspaceAddedConsumer implements Informable
{
    public function __construct(private ReportingBusInterface $reportingBus)
    {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof WorkspaceAdded;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var WorkspaceAdded $event */
        $event = $reportable;
        $this->reportingBus->report(new WorkspaceProfileFilled($event->id()));
    }

}
