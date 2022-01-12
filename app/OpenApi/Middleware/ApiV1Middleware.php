<?php

namespace App\OpenApi\Middleware;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use Vyuldashev\LaravelOpenApi\Contracts\PathMiddleware;
use Vyuldashev\LaravelOpenApi\RouteInformation;

class ApiV1Middleware implements PathMiddleware
{
    public function before(RouteInformation $routeInformation): void
    {
    }

    public function after(PathItem $pathItem): PathItem
    {
        return $pathItem->route(str_replace('/api/v1', '', $pathItem->route));
    }

}
