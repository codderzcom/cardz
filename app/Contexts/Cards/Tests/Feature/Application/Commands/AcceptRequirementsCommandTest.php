<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\AcceptRequirements;
use App\Contexts\Cards\Domain\Events\Card\RequirementsAccepted;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Cards\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class AcceptRequirementsCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_card_accepts_requirements()
    {
        $requirements = RequirementBuilder::generateSeries(10);
        $card = CardBuilder::make()->build();
        $this->getCardRepository()->persist($card);

        $command = AcceptRequirements::of($card->cardId, ...$requirements);
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $this->assertEquals($command->getRequirements(), $card->getRequirements());
        $this->assertEvent(RequirementsAccepted::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
