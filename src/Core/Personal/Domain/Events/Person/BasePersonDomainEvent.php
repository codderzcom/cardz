<?php

namespace Cardz\Core\Personal\Domain\Events\Person;

use Cardz\Core\Personal\Domain\Model\Person\Person;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateEvent;

/**
 * @method Person with()
 */
abstract class BasePersonDomainEvent extends AggregateEvent
{
}
