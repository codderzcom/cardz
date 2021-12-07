<?php

namespace Cardz\Core\Personal\Domain\Events\Person;

use Carbon\Carbon;

final class PersonJoined extends BasePersonDomainEvent
{
    private function __construct(
        private Carbon $joined,
    ) {
    }

    public static function of(Carbon $joined): self
    {
        return new self($joined);
    }
}
