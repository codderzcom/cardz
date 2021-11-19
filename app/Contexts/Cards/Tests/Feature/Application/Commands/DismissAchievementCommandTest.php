<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\DismissAchievement;
use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Cards\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class DismissAchievementCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_achievement_can_be_dismissed()
    {
        $requirements = RequirementBuilder::generateSeries();
        $card = CardBuilder::make()
            ->withRequirements(...$requirements)
            ->withAchievements(Achievement::of($requirements[0]->requirementId, $requirements[0]->description))
            ->build();
        $this->getCardRepository()->persist($card);

        $command = DismissAchievement::of($card->cardId, $requirements[0]->requirementId);
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $this->assertEmpty($card->getAchievements()->toArray());
        $this->assertEvent(AchievementDismissed::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
