<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\BusinessPlanResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class BusinessPlansResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(
                MediaType::json()->schema(Schema::array()->items(BusinessPlanResponseSchema::ref())
                    ->description('Plans for the collaborator'))
            )
            ->description('List all plans for the workspace');
    }
}
