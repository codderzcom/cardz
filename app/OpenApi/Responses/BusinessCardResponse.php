<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\BusinessCardResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class BusinessCardResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(BusinessCardResponseSchema::ref()))
            ->description('Business card');
    }
}
