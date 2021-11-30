<?php

namespace Cardz\Support\MobileAppGateway\Config\Authorization;

use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Closure;
use Codderz\Platypus\Exceptions\AuthorizationFailedException;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Http\Request;

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

        $routeName = $request->route()?->getName();
        $permission = RouteNameToPermissionMap::map($routeName);

        $objectIdName = $permission->getObjectIdName();
        $objectId = $objectIdName ? GuidBasedImmutableId::of($request->$objectIdName) : null;

        $isAllowed = $this->authorizationBus->execute(IsAllowed::of(
            $permission,
            GuidBasedImmutableId::of($subjectId),
            $objectId,
        ));

        if (!$isAllowed) {
            throw new AuthorizationFailedException("Subject is not authorized");
        }
    }
}
