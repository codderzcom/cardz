<?php

namespace App\Contexts\Shared\Contracts;

interface Informable
{
    public function accepts(Reportable $reportable): bool;

    public function inform(Reportable $reportable): void;

}
