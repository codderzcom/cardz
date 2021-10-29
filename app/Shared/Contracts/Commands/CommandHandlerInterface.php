<?php

namespace App\Shared\Contracts\Commands;

interface CommandHandlerInterface
{
    public function handles(CommandInterface $command): bool;

    public function handle(CommandInterface $command): void;

    public function getResult();
}
