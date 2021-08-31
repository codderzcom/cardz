<?php

namespace App\Contexts\Cards\Application\Controllers\Web;

use App\Contexts\Shared\Contracts\ServiceResultCode;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use JetBrains\PhpStorm\Pure;

abstract class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response(ServiceResultInterface $result): JsonResponse
    {
        return response()->json($result->toArray(), $this->resultCodeToResponseCode($result->getCode()));
    }

    #[Pure]
    private function resultCodeToResponseCode(ServiceResultCode $resultCode): int
    {
        return match ((string) $resultCode) {
            ServiceResultCode::OK => 200,
            ServiceResultCode::POLICY_VIOLATION => 400,
            ServiceResultCode::SUBJECT_NOT_FOUND => 404,
            default => 500
        };
    }
}
