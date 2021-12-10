<?php

namespace Cardz\Core\Personal\Tests\Feature\Integration\Projectors;

use Cardz\Core\Personal\Application\Commands\JoinPerson;
use Cardz\Core\Personal\Tests\Feature\PersonalTestHelperTrait;
use Cardz\Core\Personal\Tests\Support\Builders\PersonBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class PersonChangedProjectorTest extends BaseTestCase
{
    use ApplicationTestTrait, PersonalTestHelperTrait;

    public function test_projector_persists_read_model()
    {
        $personTemplate = PersonBuilder::make()->build();

        $command = JoinPerson::of($personTemplate->personId, $personTemplate->name);
        $this->commandBus()->dispatch($command);

        $person = $this->getJoinedPersonStorage()->take($command->getPersonId());

        $this->assertEquals($command->getPersonId(), $person->personId);
        $this->assertNotNull($person->joined);
    }
}
