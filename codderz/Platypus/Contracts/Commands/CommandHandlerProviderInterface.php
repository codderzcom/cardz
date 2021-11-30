<?php

namespace Codderz\Platypus\Contracts\Commands;

interface CommandHandlerProviderInterface
{
    /**
     * @return CommandHandlerInterface[]
     */
    public function getHandlers(): array;
}
