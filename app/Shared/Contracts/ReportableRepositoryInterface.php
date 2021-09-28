<?php

namespace App\Shared\Contracts;

interface ReportableRepositoryInterface
{
    public function persist(Reportable $reportable): void;
}
