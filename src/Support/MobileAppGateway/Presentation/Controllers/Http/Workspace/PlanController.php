<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use App\OpenApi\Requests\Customer\AddPlanRequestBody;
use App\OpenApi\Requests\Customer\AddRequirementRequestBody;
use App\OpenApi\Requests\Customer\ChangePlanDescriptionRequestBody;
use App\OpenApi\Requests\Customer\ChangeRequirementDescriptionRequestBody;
use App\OpenApi\Requests\Customer\LaunchPlanRequestBody;
use App\OpenApi\Responses\BusinessPlanResponse;
use App\OpenApi\Responses\BusinessPlansResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\AuthorizationExceptionResponse;
use App\OpenApi\Responses\Errors\DomainExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use Cardz\Support\MobileAppGateway\Application\Services\Workspace\PlanAppService;
use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\{Plan\AddPlanRequest,
    Plan\AddPlanRequirementRequest,
    Plan\ChangePlanDescriptionRequest,
    Plan\ChangePlanRequirementDescriptionRequest,
    Plan\LaunchPlanCommandRequest,
    Plan\PlanCommandRequest,
    Plan\RemovePlanRequirementRequest
};
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\GetPlanRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\GetWorkspaceRequest;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class PlanController extends BaseController
{
    public function __construct(
        private PlanAppService $planService,
    ) {
    }

    /**
     * Get plans
     *
     * Returns all plans in the current workspace.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(id: RouteName::GET_PLANS, tags: ['business', 'plan'])]
    #[OpenApi\Response(factory: BusinessPlansResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function getWorkspaceBusinessPlans(GetWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->planService->getWorkspaceBusinessPlans($request->workspaceId));
    }

    /**
     * Get plan
     *
     * Returns a plans in the current workspace by id.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::GET_PLAN, tags: ['business', 'plan'])]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function getPlan(GetPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->getBusinessPlan($request->planId));
    }

    /**
     * Add a new plan
     *
     * Adds a new plan to the current workspace.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(id: RouteName::ADD_PLAN, tags: ['business', 'plan'])]
    #[OpenApi\RequestBody(factory: AddPlanRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function add(AddPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->add($request->workspaceId, $request->description));
    }

    /**
     * Launch a plan
     *
     * Launches a plan to activity. Requires an expiration date for aut expiration. Can be relaunched with a new date.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::LAUNCH_PLAN, tags: ['business', 'plan'])]
    #[OpenApi\RequestBody(factory: LaunchPlanRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function launch(LaunchPlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->launch($request->planId, $request->expirationDate));
    }

    /**
     * Stop a plan
     *
     * Stops a plan from active state.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::STOP_PLAN, tags: ['business', 'plan'])]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function stop(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->stop($request->planId));
    }

    /**
     * Archive a plan
     *
     * Archives plan. Archived plans are invisible by normal means. Plans are archived automatically on their expiration date.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::ARCHIVE_PLAN, tags: ['business', 'plan'])]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function archive(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->archive($request->planId));
    }

    /**
     * Change plan description
     *
     * Changes plan description.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::CHANGE_PLAN_DESCRIPTION, tags: ['business', 'plan'])]
    #[OpenApi\RequestBody(factory: ChangePlanDescriptionRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function changeDescription(ChangePlanDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeDescription($request->planId, $request->description));
    }

    /**
     * Add plan requirement
     *
     * Adds a new requirement to the plan. Requirement changes are propagated to the relevant cards.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::ADD_PLAN_REQUIREMENT, tags: ['business', 'plan', 'requirement'])]
    #[OpenApi\RequestBody(factory: AddRequirementRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function addRequirement(AddPlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->addRequirement($request->planId, $request->description));
    }

    /**
     * Remove plan requirement
     *
     * Removes the requirement from the plan. Requirement changes are propagated to the relevant cards.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     * @param Guid $requirementId Requirement GUID
     */
    #[OpenApi\Operation(id: RouteName::REMOVE_PLAN_REQUIREMENT, tags: ['business', 'plan', 'requirement'])]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function removeRequirement(RemovePlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->removeRequirement($request->planId, $request->requirementId));
    }

    /**
     * Change plan requirement description
     *
     * Changes the requirement description. Description changes are propagated to the relevant cards.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     * @param Guid $requirementId Requirement GUID
     */
    #[OpenApi\Operation(id: RouteName::CHANGE_PLAN_REQUIREMENT, tags: ['business', 'plan', 'requirement'])]
    #[OpenApi\RequestBody(factory: ChangeRequirementDescriptionRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: AuthorizationExceptionResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function changeRequirement(ChangePlanRequirementDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeRequirement(
            $request->planId,
            $request->requirementId,
            $request->description,
        ));
    }
}
