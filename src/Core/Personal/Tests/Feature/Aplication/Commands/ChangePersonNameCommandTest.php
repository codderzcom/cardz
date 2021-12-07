<?php

namespace Cardz\Core\Personal\Tests\Feature\Aplication\Commands;

use Cardz\Core\Personal\Application\Commands\ChangePersonName;
use Cardz\Core\Personal\Domain\Events\Person\PersonNameChanged;
use Cardz\Core\Personal\Tests\Feature\PersonalTestHelperTrait;
use Cardz\Core\Personal\Tests\Support\Builders\PersonBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class ChangePersonNameCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PersonalTestHelperTrait;

    public function test_person_can_change_name()
    {
        $person = PersonBuilder::make()->build();
        $this->getPersonStore()->store(...$person->releaseEvents());

        $command = ChangePersonName::of($person->personId, 'Changed');
        $this->commandBus()->dispatch($command);

        $person = $this->getPersonStore()->restore($command->getPersonId());

        $this->assertEquals('Changed', $person->name);
        $this->assertEvent(PersonNameChanged::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
