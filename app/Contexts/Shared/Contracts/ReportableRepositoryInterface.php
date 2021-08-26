<?php

namespace App\Contexts\Shared\Contracts;

interface ReportableRepositoryInterface
{
    public function persist(Reportable $reportable): void;
}
