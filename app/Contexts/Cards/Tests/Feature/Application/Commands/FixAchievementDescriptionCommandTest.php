<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\DismissAchievement;
use App\Contexts\Cards\Application\Commands\FixAchievementDescription;
use App\Contexts\Cards\Domain\Events\Card\AchievementDescriptionFixed;
use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Cards\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class FixAchievementDescriptionCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_achievement_can_be_fixed()
    {
        $requirements = RequirementBuilder::generateSeries();
        $card = CardBuilder::make()
            ->withRequirements(...$requirements)
            ->withAchievements(Achievement::of($requirements[0]->requirementId, $requirements[0]->description))
            ->build();
        $this->getCardRepository()->persist($card);

        $command = FixAchievementDescription::of($card->cardId, $requirements[0]->requirementId, 'Changed');
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $this->assertEquals('Changed', $card->getAchievements()->toArray()[0][1]);
        $this->assertEvent(AchievementDescriptionFixed::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
