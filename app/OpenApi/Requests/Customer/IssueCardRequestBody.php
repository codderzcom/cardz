<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\NewCardRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class IssueCardRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('IssueCard')
            ->description('Issue card request')
            ->content(
                MediaType::json()->schema(NewCardRequestSchema::ref())
            );
    }

}
