<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\IssuedCardResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class IssuedCardsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(Schema::array('IssuedCards')->items(IssuedCardResponseSchema::ref())))
            ->description('All of the customer\'s issued cards');
    }
}
