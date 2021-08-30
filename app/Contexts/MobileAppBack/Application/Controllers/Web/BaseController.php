<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web;

use App\Contexts\MobileAppBack\Application\Contracts\ApplicationServiceResultCode;
use App\Contexts\MobileAppBack\Application\Services\Shared\ApplicationServiceResult;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use JetBrains\PhpStorm\Pure;

abstract class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response(ApplicationServiceResult $result): JsonResponse
    {
        return response()->json($result->toArray(), $this->resultCodeToResponseCode($result->getCode()));
    }

    #[Pure]
    private function resultCodeToResponseCode(ApplicationServiceResultCode $resultCode): int
    {
        return match ((string) $resultCode) {
            ApplicationServiceResultCode::OK => 200,
            ApplicationServiceResultCode::POLICY_VIOLATION => 400,
            ApplicationServiceResultCode::SUBJECT_NOT_FOUND => 404,
            default => 500
        };
    }
}
