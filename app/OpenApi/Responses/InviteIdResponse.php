<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class InviteIdResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(
                Schema::string()->format(Schema::FORMAT_UUID)->description('Invite Id')
            ))
            ->description('Invite Id');
    }
}
