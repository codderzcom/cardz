<?php

namespace Cardz\Core\Personal\Domain\Model\Person;

use Carbon\Carbon;
use Cardz\Core\Personal\Domain\Events\Person\PersonJoined;
use Cardz\Core\Personal\Domain\Events\Person\PersonNameChanged;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;

final class Person implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $joined = null;

    private function __construct(
        public PersonId $personId,
        public Name $name,
    ) {
    }

    public static function join(PersonId $personId, Name $name): self
    {
        $person = new self($personId, $name);
        $person->joined = Carbon::now();
        return $person->withEvents(PersonJoined::of($person));
    }

    public static function restore(string $personId, string $name, ?Carbon $joined): self
    {
        $person = new self(PersonId::of($personId), Name::of($name));
        $person->joined = $joined;
        return $person;
    }

    public function changeName(Name $name): self
    {
        $this->name = $name;
        return $this->withEvents(PersonNameChanged::of($this));
    }

    public function isJoined(): bool
    {
        return $this->joined !== null;
    }
}
