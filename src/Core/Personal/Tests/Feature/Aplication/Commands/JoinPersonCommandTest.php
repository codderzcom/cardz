<?php

namespace Cardz\Core\Personal\Tests\Feature\Aplication\Commands;

use Cardz\Core\Personal\Application\Commands\JoinPerson;
use Cardz\Core\Personal\Domain\Events\Person\PersonJoined;
use Cardz\Core\Personal\Tests\Feature\PersonalTestHelperTrait;
use Cardz\Core\Personal\Tests\Support\Builders\PersonBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class JoinPersonCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PersonalTestHelperTrait;

    public function test_person_can_join()
    {
        $personTemplate = PersonBuilder::make()->build();

        $command = JoinPerson::of($personTemplate->personId, $personTemplate->name);
        $this->commandBus()->dispatch($command);

        $person = $this->getPersonRepository()->take($command->getPersonId());

        $this->assertEquals($command->getPersonId(), $person->personId);
        $this->assertTrue($person->isJoined());
        $this->assertEvent(PersonJoined::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
