<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\GetTokenRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class GetTokenRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('GetCustomerAccessToken')
            ->description(
                'Get customer API access token for the specific device. <br>
                          With each request new token is generated. Old ones are invalidated shortly after. <br>
                          *Tokens on other customer devices remain unaffected.
            ')
            ->content(
                MediaType::json()->schema(GetTokenRequestSchema::ref())
            );
    }

}
