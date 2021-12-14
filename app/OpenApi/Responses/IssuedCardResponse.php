<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\IssuedCardResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class IssuedCardResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(IssuedCardResponseSchema::ref()))
            ->description('Successful response');
    }
}
