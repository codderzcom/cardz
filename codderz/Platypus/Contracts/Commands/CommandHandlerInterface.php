<?php

namespace Codderz\Platypus\Contracts\Commands;

interface CommandHandlerInterface
{
    public function handles(CommandInterface $command): bool;

    public function handle(CommandInterface $command): void;
}
