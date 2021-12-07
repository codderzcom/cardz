<?php

namespace Cardz\Core\Personal\Domain\Events\Person;

use Carbon\Carbon;
use Cardz\Core\Personal\Domain\Model\Person\Name;

final class PersonJoined extends BasePersonDomainEvent
{
    private function __construct(
        public Name $name,
        public Carbon $joined,
    ) {
    }

    public static function of(Name $name, Carbon $joined): self
    {
        return new self($name, $joined);
    }

    public static function from(array $data): self
    {
        return new self(Name::of($data['name']), new Carbon($data['joined']));
    }
}
