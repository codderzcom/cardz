<?php

namespace Cardz\Core\Personal\Domain\ReadModel\Contracts;

use Cardz\Core\Personal\Domain\Exception\PersonNotFoundExceptionInterface;
use Cardz\Core\Personal\Domain\ReadModel\JoinedPerson;

interface JoinedPersonStorageInterface
{
    public function persist(JoinedPerson $joinedPerson): void;

    /**
     * @throws PersonNotFoundExceptionInterface
     */
    public function take(string $personId): JoinedPerson;
}
