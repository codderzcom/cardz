<?php

namespace App\Contexts\Personal\Application\Services;

use App\Contexts\Personal\Application\Contracts\PersonRepositoryInterface;
use App\Contexts\Personal\Application\IntegrationEvents\PersonJoined;
use App\Contexts\Personal\Application\IntegrationEvents\PersonNameChanged;
use App\Contexts\Personal\Domain\Model\Person\Name;
use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class PersonAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private PersonRepositoryInterface $personRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function join(string $personId, string $name): ServiceResultInterface
    {
        $person = Person::make(PersonId::of($personId), Name::of($name));
        $person->join();
        $this->personRepository->persist($person);

        $result = $this->serviceResultFactory->ok($person, new PersonJoined($person->personId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function changeName(string $personId, string $name): ServiceResultInterface
    {
        $person = $this->personRepository->take(PersonId::of($personId));
        if ($person === null) {
            return $this->serviceResultFactory->notFound("Person $personId not found");
        }
        $person->changeName(Name::of($name));
        $this->personRepository->persist($person);

        $result = $this->serviceResultFactory->ok($person, new PersonNameChanged($person->personId));
        return $this->reportResult($result, $this->reportingBus);
    }
}
