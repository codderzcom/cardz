<?php

namespace Cardz\Core\Personal\Domain\Events\Person;

use Cardz\Core\Personal\Domain\Model\Person\Name;

final class PersonNameChanged extends BasePersonDomainEvent
{
    private function __construct(
        private Name $name,
    ) {
    }

    public static function of(Name $name): self
    {
        return new self($name);
    }
}
