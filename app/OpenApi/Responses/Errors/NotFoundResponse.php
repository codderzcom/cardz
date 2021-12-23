<?php

namespace App\OpenApi\Responses\Errors;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class NotFoundResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::notFound('NotFound')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('message')
                            ->description('Requested resource not found')
                            ->example('Not found exception: <Resource Name>: <Resource Id>')
                    )
                )
            );
    }

}
