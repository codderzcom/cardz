<?php

namespace Cardz\Core\Personal\Infrastructure\ReadStorage\Eloquent;

use App\Models\Person as EloquentPerson;
use Cardz\Core\Personal\Domain\ReadModel\Contracts\JoinedPersonStorageInterface;
use Cardz\Core\Personal\Domain\ReadModel\JoinedPerson;
use Cardz\Core\Personal\Infrastructure\Exceptions\PersonNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;
use JetBrains\PhpStorm\ArrayShape;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

class JoinedPersonStorage implements JoinedPersonStorageInterface
{
    use PropertiesExtractorTrait;

    public function persist(JoinedPerson $joinedPerson): void
    {
        EloquentPerson::query()->updateOrCreate(
            ['id' => $joinedPerson->personId],
            $this->personAsData($joinedPerson)
        );
    }

    public function take(string $personId = null): JoinedPerson
    {
        /** @var EloquentPerson $eloquentPerson */
        $eloquentPerson = EloquentPerson::query()->find((string) $personId);
        if ($eloquentPerson === null) {
            throw new PersonNotFoundException((string) $personId);
        }
        return $this->personFromData($eloquentPerson);
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'joined_at' => Carbon::class])]
    private function personAsData(JoinedPerson $joinedPerson): array
    {
        return [
            'id' => $joinedPerson->personId,
            'name' => $joinedPerson->name,
            'joined_at' => $joinedPerson->joined,
        ];
    }

    #[Pure]
    private function personFromData(EloquentPerson $eloquentPerson): JoinedPerson
    {
        return new JoinedPerson(
            $eloquentPerson->id,
            $eloquentPerson->name,
            $eloquentPerson->joined_at,
        );
    }
}
