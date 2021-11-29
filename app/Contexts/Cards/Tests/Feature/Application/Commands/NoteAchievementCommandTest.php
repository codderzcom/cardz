<?php

namespace App\Contexts\Cards\Tests\Feature\Application\Commands;

use App\Contexts\Cards\Application\Commands\NoteAchievement;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted;
use App\Contexts\Cards\Domain\Model\Card\Achievements;
use App\Contexts\Cards\Tests\Feature\CardsTestHelperTrait;
use App\Contexts\Cards\Tests\Support\Builders\CardBuilder;
use App\Contexts\Cards\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class NoteAchievementCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CardsTestHelperTrait;

    public function test_achievement_can_be_noted()
    {
        $requirements = RequirementBuilder::generateSeries();
        $card = CardBuilder::make()->withRequirements(...$requirements)->build();
        $this->getCardRepository()->persist($card);

        $command = NoteAchievement::of($card->cardId, $requirements[0]->requirementId, $requirements[0]->description);
        $this->commandBus()->dispatch($command);

        $card = $this->getCardRepository()->take($command->getCardId());

        $requirements = Achievements::from(...$requirements);
        $this->assertEquals($requirements->toArray()[0], $card->getAchievements()->toArray()[0]);
        $this->assertEvent(AchievementNoted::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
