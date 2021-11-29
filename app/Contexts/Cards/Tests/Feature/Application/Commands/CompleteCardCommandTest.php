<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\CompleteCard;
use App\Contexts\Cards\Domain\Events\Card\CardCompleted;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class CompleteCardCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_card_can_be_completed()
    {
        $card = CardBuilder::make()->build();
        $this->getCardRepository()->persist($card);

        $this->assertFalse($card->isCompleted());

        $command = CompleteCard::of($card->cardId);
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $this->assertTrue($card->isCompleted());
        $this->assertEvent(CardCompleted::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
