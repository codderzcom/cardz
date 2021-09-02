<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Contracts\AchievementRepositoryInterface;
use App\Contexts\Plans\Application\IntegrationEvents\AchievementAdded;
use App\Contexts\Plans\Application\IntegrationEvents\AchievementChanged;
use App\Contexts\Plans\Application\IntegrationEvents\AchievementRemoved;
use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Shared\Description;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;

class AchievementAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private AchievementRepositoryInterface $achievementRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $resultFactory,
    ) {
    }

    public function add(string $planId, string $description): ServiceResultInterface
    {
        $achievement = Achievement::make(
            AchievementId::make(),
            PlanId::of($planId),
            Description::of($description)
        );

        $achievement->add();
        $this->achievementRepository->persist($achievement);

        $result = $this->resultFactory->ok($achievement, new AchievementAdded($achievement->achievementId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function remove(string $achievementId): ServiceResultInterface
    {
        $achievement = $this->achievementRepository->take(AchievementId::of($achievementId));
        if ($achievement === null) {
            return $this->resultFactory->notFound("$achievementId not found");
        }

        $achievement->remove();
        $this->achievementRepository->persist($achievement);

        $result = $this->resultFactory->ok($achievement, new AchievementRemoved($achievement->achievementId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function change(string $achievementId, string $description): ServiceResultInterface
    {
        $achievement = $this->achievementRepository->take(AchievementId::of($achievementId));
        if ($achievement === null) {
            return $this->resultFactory->notFound("$achievementId not found");
        }

        $achievement->change(Description::of($description));
        $this->achievementRepository->persist($achievement);

        $result = $this->resultFactory->ok($achievement, new AchievementChanged($achievement->achievementId));
        return $this->reportResult($result, $this->reportingBus);
    }
}
