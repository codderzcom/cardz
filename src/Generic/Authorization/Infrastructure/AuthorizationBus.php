<?php

namespace Cardz\Generic\Authorization\Infrastructure;

use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Codderz\Platypus\Infrastructure\QueryHandling\SyncQueryBus;

class AuthorizationBus extends SyncQueryBus implements AuthorizationBusInterface
{

}
