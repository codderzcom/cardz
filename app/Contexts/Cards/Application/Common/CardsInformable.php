<?php

namespace App\Contexts\Cards\Application\Common;

interface CardsInformable
{
    public function accepts(CardsReportable $reportable): bool;

    public function inform(CardsReportable $reportable): void;

}
