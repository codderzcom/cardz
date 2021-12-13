<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Documentation\Customer\Requests;

use App\OpenApi\Schemas\RegisterRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class RegisterRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('RegisterCustomer')
            ->description('Register new customer')
            ->content(
                MediaType::json()->schema(RegisterRequestSchema::ref())
            );
    }

}
