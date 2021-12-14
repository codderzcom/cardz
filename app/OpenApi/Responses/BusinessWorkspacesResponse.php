<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\BusinessWorkspaceResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class BusinessWorkspacesResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(
                MediaType::json()->schema(Schema::array()->items(BusinessWorkspaceResponseSchema::ref())
                    ->description('Workspace (business) for the collaborator'))
            )
            ->description('List all workspaces of the current collaborator');
    }
}
