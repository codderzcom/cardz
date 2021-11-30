<?php

namespace Cardz\Support\MobileAppGateway\Config\Authorization;

use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Support\MobileAppGateway\Application\Exceptions\AccessDeniedException;
use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;
use Closure;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationMiddleware
{
    public function __construct(
        private AuthorizationBusInterface $authorizationBus,
    ) {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        $this->authorize($request);
        return $next($request);
    }

    private function authorize(Request $request): void
    {
        $subjectId = $request->user()?->id;
        if (!$subjectId) {
            return;
        }

        $isAllowedQuery = $this->requestToQuery($request);
        if (!$this->authorizationBus->execute($isAllowedQuery)) {
            $message = sprintf(
                "Subject %s is not authorized for %s %s",
                $isAllowedQuery->subjectId,
                $isAllowedQuery->permission->getObjectType(),
                $isAllowedQuery->objectId,
            );
            throw new AccessDeniedException($message);
        }
    }

    private function requestToQuery(Request $request): IsAllowed
    {
        $routeName = $request->route()?->getName();
        $permission = RouteNameToPermissionMap::map($routeName);

        $objectIdName = $permission->getObjectIdName();
        $objectId = $objectIdName !== null ? GuidBasedImmutableId::of($request->$objectIdName) : null;

        return IsAllowed::of(
            $permission,
            GuidBasedImmutableId::of($request->user()?->id),
            $objectId,
        );
    }
}
