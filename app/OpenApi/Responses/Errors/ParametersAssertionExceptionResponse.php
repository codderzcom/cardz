<?php

namespace App\OpenApi\Responses\Errors;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ParametersAssertionExceptionResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::badRequest('ParametersAssertionException')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('message')
                            ->description('Parameters Assertion Exception')
                            ->example('Wrong string format for UUID')
                    )
                )
            );
    }

}
