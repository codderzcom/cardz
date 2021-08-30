<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($payload = [], $code = 200): JsonResponse
    {
        return response()->json($payload, $code);
    }

    public function notFound($payload = null): JsonResponse
    {
        return $this->error($payload, 404, 'Not found');
    }

    public function error($payload = null, $code = 500, ?string $message = null): JsonResponse
    {
        $payload = $payload ?? [];
        $payload['error'] = $message ?? 'Error';
        return response()->json($payload, $code);
    }
}
