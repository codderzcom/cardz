<?php

namespace App\Shared\Contracts;

interface Informable
{
    public function accepts(Reportable $reportable): bool;

    public function inform(Reportable $reportable): void;

}
