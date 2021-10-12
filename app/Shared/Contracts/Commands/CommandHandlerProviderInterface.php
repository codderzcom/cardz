<?php

namespace App\Shared\Contracts\Commands;

interface CommandHandlerProviderInterface
{
    /**
     * @return CommandHandlerInterface[]
     */
    public function getHandlers(): array;
}
