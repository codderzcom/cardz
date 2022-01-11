<?php

namespace App\OpenApi\Responses\Errors;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UnexpectedExceptionResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::internalServerError('UnexpectedException')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('message')
                            ->nullable(false)
                            ->description('Unexpected Exception')
                            ->example('Unexpected exception')
                    )
                )
            );
    }

}
