<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\IssueCard;
use App\Contexts\Cards\Domain\Events\Card\CardIssued;
use App\Contexts\Cards\Domain\Model\Card\CustomerId;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class IssueCardCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_card_can_be_issued()
    {
        $command = IssueCard::of(PlanId::makeValue(), CustomerId::makeValue());
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $this->assertEquals($command->getCardId(), $card->cardId);
        $this->assertEvent(CardIssued::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
