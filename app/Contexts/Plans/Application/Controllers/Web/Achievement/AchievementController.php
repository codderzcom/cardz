<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Achievement;

use App\Contexts\Plans\Application\Contracts\AchievementRepositoryInterface;
use App\Contexts\Plans\Application\Controllers\Web\Achievement\Commands\{AddAchievementRequest, ChangeAchievementRequest, RemoveAchievementRequest};
use App\Contexts\Plans\Application\Controllers\Web\BaseController;
use App\Contexts\Plans\Application\IntegrationEvents\AchievementAdded;
use App\Contexts\Plans\Application\IntegrationEvents\AchievementChanged;
use App\Contexts\Plans\Application\IntegrationEvents\AchievementRemoved;
use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Http\JsonResponse;

class AchievementController extends BaseController
{
    public function __construct(
        private AchievementRepositoryInterface $achievementRepository,
        ReportingBusInterface $reportingBus
    ) {
        parent::__construct($reportingBus);
    }

    public function add(AddAchievementRequest $request): JsonResponse
    {
        $achievement = Achievement::create($request->achievementId, $request->planId, $request->description);
        $achievement?->add();
        $this->achievementRepository->persist($achievement);
        return $this->success(new AchievementAdded($achievement?->achievementId, 'Achievement'));
    }

    public function remove(RemoveAchievementRequest $request): JsonResponse
    {
        $achievement = $this->achievementRepository->take($request->achievementId);
        $achievement?->remove();
        $this->achievementRepository->persist($achievement);
        return $this->success(new AchievementRemoved($achievement?->achievementId, 'Achievement'));
    }

    public function change(ChangeAchievementRequest $request): JsonResponse
    {
        $achievement = $this->achievementRepository->take($request->achievementId);
        $achievement?->change($request->description);
        $this->achievementRepository->persist($achievement);
        return $this->success(new AchievementChanged($achievement?->achievementId, 'Achievement'));
    }

}
