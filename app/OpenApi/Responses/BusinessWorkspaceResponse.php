<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\BusinessWorkspaceResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class BusinessWorkspaceResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(
                MediaType::json()->schema(BusinessWorkspaceResponseSchema::ref())
            )
            ->description('Business Workspace');
    }
}
