<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\PlanExpirationRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class LaunchPlanRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('LaunchPlan')
            ->description('Launch plan request')
            ->content(
                MediaType::json()->schema(PlanExpirationRequestSchema::ref())
            );
    }

}
