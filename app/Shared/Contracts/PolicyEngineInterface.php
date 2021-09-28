<?php

namespace App\Shared\Contracts;

use Closure;

interface PolicyEngineInterface
{
    public function passTrough(Closure $closure, PolicyAssertionInterface ...$policies): ServiceResultInterface;
}
