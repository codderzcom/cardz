<?php

namespace App\Contexts\Personal\Domain\Model\Person;

use App\Contexts\Personal\Domain\Events\Person\PersonJoined;
use App\Contexts\Personal\Domain\Events\Person\PersonNameChanged;
use App\Contexts\Personal\Domain\Model\Shared\AggregateRoot;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Person extends AggregateRoot
{
    private ?Carbon $joined = null;

    private function __construct(
        public PersonId $personId,
        public Name $name,
    ) {
    }

    #[Pure]
    public static function make(PersonId $personId, Name $name): self
    {
        return new self($personId, $name);
    }

    public function join(): PersonJoined
    {
        $this->joined = Carbon::now();
        return PersonJoined::with($this->personId);
    }

    public function changeName(Name $name): PersonNameChanged
    {
        $this->name = $name;
        return PersonNameChanged::with($this->personId);
    }

    public function isJoined(): bool
    {
        return $this->joined !== null;
    }

    private function from(
        string $personId,
        string $name,
        ?Carbon $joined,
    ): void {
        $this->personId = PersonId::of($personId);
        $this->name = Name::of($name);
        $this->joined = $joined;
    }
}
