<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\BusinessPlanResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class BusinessPlanResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(BusinessPlanResponseSchema::ref()))
            ->description('Business plan');
    }
}
