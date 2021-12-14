<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CustomerWorkspaceResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CustomerWorkspacesResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(
                MediaType::json()->schema(Schema::array()->items(CustomerWorkspaceResponseSchema::ref())
                    ->description('List of all workspaces'))
            )
            ->description('Customer Workspace');
    }
}
