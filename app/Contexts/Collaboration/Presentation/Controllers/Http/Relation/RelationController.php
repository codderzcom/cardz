<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Relation;

use App\Contexts\Collaboration\Application\Services\RelationAppService;
use App\Contexts\Collaboration\Presentation\Controllers\Http\BaseController;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Relation\Commands\RelationRequest;
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
