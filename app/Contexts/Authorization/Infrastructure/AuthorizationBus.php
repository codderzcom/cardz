<?php

namespace App\Contexts\Authorization\Infrastructure;

use App\Contexts\Authorization\Application\AuthorizationBusInterface;
use App\Shared\Infrastructure\QueryHandling\SyncQueryBus;

class AuthorizationBus extends SyncQueryBus implements AuthorizationBusInterface
{

}
