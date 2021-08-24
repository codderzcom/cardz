<?php

namespace App\Contexts\Cards\Application\Controllers\Web;

use App\Contexts\Cards\Application\IntegrationEvents\CardsReportable;
use App\Contexts\Cards\Infrasctructure\Messaging\ReportingBus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        private ReportingBus $reportingBus
    ) {
    }

    public function successApiResponse(CardsReportable $reportable = null, $payload = [], $code = 200): JsonResponse
    {
        if ($reportable) {
            $this->reportingBus->acceptReportable($reportable);
            $payload['IntegrationEvent'] = (string) $reportable;
        }
        return response()->json($payload, $code);
    }
}
