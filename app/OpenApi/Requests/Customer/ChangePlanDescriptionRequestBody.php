<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\PlanProfileRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ChangePlanDescriptionRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('ChangePlanDescription')
            ->description('Change plan description request')
            ->content(
                MediaType::json()->schema(PlanProfileRequestSchema::ref())
            );
    }

}
