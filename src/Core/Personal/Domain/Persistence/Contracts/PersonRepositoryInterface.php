<?php

namespace Cardz\Core\Personal\Domain\Persistence\Contracts;

use Cardz\Core\Personal\Domain\Exception\PersonNotFoundExceptionInterface;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;

interface PersonRepositoryInterface
{
    public function persist(Person $person): void;

    /**
     * @throws PersonNotFoundExceptionInterface
     */
    public function take(PersonId $personId): Person;
}
