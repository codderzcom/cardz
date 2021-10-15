<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http;

use App\Shared\Contracts\ServiceResultCode;
use App\Shared\Contracts\ServiceResultInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use JetBrains\PhpStorm\Pure;

abstract class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($result): JsonResponse
    {
        return response()->json($result);
    }
}
