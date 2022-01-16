<?php

namespace Cardz\Core\Personal\Application\Commands;

use Cardz\Core\Personal\Domain\Model\Person\Name;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;
use JetBrains\PhpStorm\Pure;

final class ChangePersonName implements CommandInterface
{
    private function __construct(
        private string $personId,
        private string $name,
    ) {
    }

    #[Pure]
    public static function of(string $personId, string $name): self
    {
        return new self($personId, $name);
    }

    public function getPersonId(): PersonId
    {
        return PersonId::of($this->personId);
    }

    #[Pure]
    public function getName(): Name
    {
        return Name::of($this->name);
    }
}
