<?php

namespace Cardz\Core\Personal\Domain\Events\Person;

use Cardz\Core\Personal\Domain\Model\Person\Name;

final class PersonNameChanged extends BasePersonDomainEvent
{
    private function __construct(
        public Name $name,
    ) {
    }

    public static function of(Name $name): self
    {
        return new self($name);
    }

    public static function from(array $data): self
    {
        return new self(Name::of($data['name']));
    }
}
