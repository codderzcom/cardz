<?php

namespace Cardz\Core\Personal\Application\Commands;

use Cardz\Core\Personal\Domain\Model\Person\Name;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

final class ChangePersonName implements CommandInterface
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
