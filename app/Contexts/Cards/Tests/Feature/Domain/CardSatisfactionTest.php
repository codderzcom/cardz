<?php

namespace App\Contexts\Cards\Tests\Feature\Domain;

use App\Contexts\Cards\Domain\Events\Card\CardSatisfactionWithdrawn;
use App\Contexts\Cards\Domain\Events\Card\CardSatisfied;
use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\Model\Card\CustomerId;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Cards\Tests\Support\Builders\PlanBuilder;
use App\Contexts\Cards\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\BaseTestCase;
use App\Shared\Infrastructure\Tests\DomainTestTrait;
use Carbon\Carbon;

class CardSatisfactionTest extends BaseTestCase
{
    use DomainTestTrait, CardsTestHelperTrait;

    public function test_issued_card_on_empty_plan_is_satisfied()
    {
        $planBuilder = PlanBuilder::make();
        $planBuilder->requirements = [];

        $cardId = CardId::make();
        $card = $planBuilder->build()->issueCard($cardId, CustomerId::make());
        $this->assertTrue($card->isSatisfied());
        $this->assertDomainEvent($card, CardSatisfied::class);
    }

    public function test_issued_card_is_satisfied_on_requirements_completed()
    {
        $requirement = RequirementBuilder::make()->build();
        $planBuilder = PlanBuilder::make();
        $planBuilder->requirements = [$requirement];

        $cardId = CardId::make();
        $card = $planBuilder->build()->issueCard($cardId, CustomerId::make());
        $this->assertFalse($card->isSatisfied());

        $card->noteAchievement(Achievement::of($requirement->requirementId, $requirement->description));
        $this->assertTrue($card->isSatisfied());
        $this->assertDomainEvent($card, CardSatisfied::class);
    }

    public function test_satisfaction_is_withdrawn_on_dismissing_achievement()
    {
        $requirement = RequirementBuilder::make()->build();
        $achievement = Achievement::of($requirement->requirementId, $requirement->description);
        $cardBuilder = CardBuilder::make()
            ->withRequirements($requirement)
            ->withAchievements($achievement);
        $cardBuilder->satisfied = Carbon::now();
        $card= $cardBuilder->build();

        $card->dismissAchievement($requirement->requirementId);
        $this->assertFalse($card->isSatisfied());
        $this->assertDomainEvent($card, CardSatisfactionWithdrawn::class);
    }

    public function setUp(): void
    {
        parent::setUp();
    }
}
