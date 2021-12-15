<?php

namespace App\OpenApi\Responses\Errors;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UnexpectedExceptionResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::internalServerError('UnexpectedException')->statusCode(500);
    }

}
