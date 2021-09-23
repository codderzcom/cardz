<?php

namespace App\Contexts\Workspaces\Application\Controllers\Consumers;

use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceAdded;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceProfileFilled;

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
