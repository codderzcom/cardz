<?php

namespace App\OpenApi\Responses\Errors;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AuthorizationExceptionResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::forbidden('AuthorizationException')
            ->content(MediaType::json()->schema(Schema::string()->description('Authorization Exception')));
    }

}
