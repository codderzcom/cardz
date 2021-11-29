<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\BlockCard;
use App\Contexts\Cards\Domain\Events\Card\CardBlocked;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class BlockCardCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_card_can_be_blocked()
    {
        $card = CardBuilder::make()->build();
        $this->getCardRepository()->persist($card);

        $this->assertFalse($card->isBlocked());

        $command = BlockCard::of($card->cardId);
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $this->assertTrue($card->isBlocked());
        $this->assertEvent(CardBlocked::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
