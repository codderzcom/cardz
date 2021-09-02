<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Achievement;

use App\Contexts\Plans\Application\Controllers\Web\Achievement\Commands\{AddAchievementRequest, ChangeAchievementRequest, RemoveAchievementRequest};
use App\Contexts\Plans\Application\Controllers\Web\BaseController;
use App\Contexts\Plans\Application\Services\AchievementAppService;
use Illuminate\Http\JsonResponse;

class AchievementController extends BaseController
{
    public function __construct(
        private AchievementAppService $achievementAppService,
    ) {
    }

    public function add(AddAchievementRequest $request): JsonResponse
    {
        return $this->response($this->achievementAppService->add(
            $request->planId,
            $request->description,
        ));
    }

    public function remove(RemoveAchievementRequest $request): JsonResponse
    {
        return $this->response($this->achievementAppService->remove(
            $request->achievementId,
        ));
    }

    public function change(ChangeAchievementRequest $request): JsonResponse
    {
        return $this->response($this->achievementAppService->change(
            $request->achievementId,
            $request->description,
        ));
    }

}
