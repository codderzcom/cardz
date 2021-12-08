<?php

namespace Cardz\Core\Personal\Domain\Persistence\Contracts;

use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;

interface PersonRepositoryInterface
{
    /**
     * @return AggregateEventInterface
     */
    public function store(Person $person): array;

    public function restore(PersonId $personId): Person;
}
