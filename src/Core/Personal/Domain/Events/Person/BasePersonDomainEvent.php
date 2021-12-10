<?php

namespace Cardz\Core\Personal\Domain\Events\Person;

use Cardz\Core\Personal\Domain\Model\Person\Person;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateEventTrait;

/**
 * @method Person with()
 */
abstract class BasePersonDomainEvent implements AggregateEventInterface
{
    use AggregateEventTrait;

    protected int $version = 1;

    public function version(): int
    {
        return $this->version;
    }
}
