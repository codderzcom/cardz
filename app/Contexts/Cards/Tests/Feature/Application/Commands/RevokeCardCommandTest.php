<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\RevokeCard;
use App\Contexts\Cards\Domain\Events\Card\CardRevoked;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class RevokeCardCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_card_can_be_revoked()
    {
        $card = CardBuilder::make()->build();
        $this->getCardRepository()->persist($card);

        $this->assertFalse($card->isRevoked());

        $command = RevokeCard::of($card->cardId);
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $this->assertTrue($card->isRevoked());
        $this->assertEvent(CardRevoked::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
