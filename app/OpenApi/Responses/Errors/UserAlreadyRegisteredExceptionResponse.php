<?php

namespace App\OpenApi\Responses\Errors;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UserAlreadyRegisteredExceptionResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::badRequest('UserAlreadyRegisteredException')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('message')
                            ->nullable(false)
                            ->description('User Already Registered Exception')
                            ->example('User with given identity already registered')
                    )->required('message')
                )
            );
    }

}
