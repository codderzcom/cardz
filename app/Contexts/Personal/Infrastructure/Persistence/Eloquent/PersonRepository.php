<?php

namespace App\Contexts\Personal\Infrastructure\Persistence\Eloquent;

use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Contexts\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use App\Contexts\Personal\Infrastructure\Exceptions\PersonNotFoundException;
use App\Models\Person as EloquentPerson;
use App\Shared\Infrastructure\Support\PropertiesExtractorTrait;

class PersonRepository implements PersonRepositoryInterface
{
    use PropertiesExtractorTrait;

    public function persist(Person $person): void
    {
        EloquentPerson::query()->updateOrCreate(
            ['id' => $person->personId],
            $this->personAsData($person)
        );
    }

    public function take(PersonId $personId = null): Person
    {
        /** @var EloquentPerson $eloquentPerson */
        $eloquentPerson = EloquentPerson::query()->find((string) $personId);
        if ($eloquentPerson === null) {
            throw new PersonNotFoundException((string) $personId);
        }
        return $this->personFromData($eloquentPerson);
    }

    private function personAsData(Person $person): array
    {
        $data = [
            'id' => (string) $person->personId,
            'name' => (string) $person->name,
            'joined' => $this->extractProperty($person, 'joined'),
        ];

        return $data;
    }

    private function personFromData(EloquentPerson $eloquentPerson): Person
    {
        $person = Person::restore(
            $eloquentPerson->id,
            $eloquentPerson->name,
            $eloquentPerson->joined_at,
        );
        return $person;
    }
}
