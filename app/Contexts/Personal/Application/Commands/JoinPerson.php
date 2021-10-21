<?php

namespace App\Contexts\Personal\Application\Commands;

use App\Contexts\Personal\Domain\Model\Person\Name;
use App\Contexts\Personal\Domain\Model\Person\PersonId;

final class JoinPerson implements JoinPersonCommandInterface
{
    private function __construct(
        private string $personId,
        private string $name,
    ) {
    }

    public static function of(string $personId, string $name): self
    {
        return new self($personId, $name);
    }

    public function getPersonId(): PersonId
    {
        return PersonId::of($this->personId);
    }

    public function getName(): Name
    {
        return Name::of($this->name);
    }
}
