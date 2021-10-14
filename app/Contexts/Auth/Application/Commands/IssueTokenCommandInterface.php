<?php

namespace App\Contexts\Auth\Application\Commands;

use App\Shared\Contracts\Commands\CommandInterface;

interface IssueTokenCommandInterface extends CommandInterface
{
    public function getIdentity(): string;

    public function getPassword(): string;

    public function getDeviceName(): string;
}
