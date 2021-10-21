<?php

namespace App\Contexts\Personal\Application\Services;

use App\Contexts\Personal\Application\Commands\ChangePersonNameCommandInterface;
use App\Contexts\Personal\Application\Commands\JoinPersonCommandInterface;
use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Contexts\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use App\Contexts\Personal\Infrastructure\Messaging\DomainEventBusInterface;

class PersonAppService
{
    public function __construct(
        private PersonRepositoryInterface $personRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function join(JoinPersonCommandInterface $command): PersonId
    {
        $person = Person::join($command->getPersonId(), $command->getName());
        $this->personRepository->persist($person);
        $this->domainEventBus->publish(...$person->releaseEvents());
        return $person->personId;
    }

    public function changeName(ChangePersonNameCommandInterface $command): PersonId
    {
        $person = $this->personRepository->take($command->getPersonId());
        $person->changeName($command->getName());
        $this->personRepository->persist($person);
        $this->domainEventBus->publish(...$person->releaseEvents());
        return $person->personId;
    }
}
