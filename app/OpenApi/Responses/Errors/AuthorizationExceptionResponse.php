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
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('message')
                            ->description('Authorization Exception')
                            ->example('Subject <Subject Id> is not authorized for <Resource Type> <Resource Id>')
                    )
                )
            );
    }

}
