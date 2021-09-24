<?php

namespace App\Contexts\Collaboration\Application\Controllers\Web\Relation;

use App\Contexts\Collaboration\Application\Controllers\Web\BaseController;
use App\Contexts\Collaboration\Application\Controllers\Web\Relation\Commands\RelationRequest;
use App\Contexts\Collaboration\Application\Services\RelationAppService;
use Illuminate\Http\JsonResponse;

class RelationController extends BaseController
{
    public function __construct(
        private RelationAppService $relationAppService,
    ) {
    }

    public function leave(RelationRequest $request): JsonResponse
    {
        return $this->response($this->relationAppService->leave(
            $request->relationId,
        ));
    }
}
