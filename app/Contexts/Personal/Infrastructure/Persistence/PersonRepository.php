<?php

namespace App\Contexts\Personal\Infrastructure\Persistence;

use App\Contexts\Personal\Application\Contracts\PersonRepositoryInterface;
use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Models\Person as EloquentPerson;
use ReflectionClass;

class PersonRepository implements PersonRepositoryInterface
{
    public function persist(Person $person): void
    {
        EloquentPerson::query()->updateOrCreate(
            ['id' => $person->personId],
            $this->personAsData($person)
        );
    }

    public function take(PersonId $personId = null): ?Person
    {
        /** @var EloquentPerson $eloquentPerson */
        $eloquentPerson = EloquentPerson::query()->find((string) $personId);
        if ($eloquentPerson === null) {
            return null;
        }
        return $this->personFromData($eloquentPerson);
    }

    private function personAsData(Person $person): array
    {
        $reflection = new ReflectionClass($person);
        $properties = [
            'joined' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($person);
        }

        $data = [
            'id' => (string) $person->personId,
            'name' => (string) $person->name,
        ];

        return $data;
    }

    private function personFromData(EloquentPerson $eloquentPerson): Person
    {
        $reflection = new ReflectionClass(Person::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Person $person */
        $person = $reflection->newInstanceWithoutConstructor();

        $creator?->invoke($person,
            $eloquentPerson->id,
            $eloquentPerson->name,
            $eloquentPerson->joined_at,
        );
        return $person;
    }
}
