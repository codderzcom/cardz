<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\PlanProfileRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class AddPlanRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('AddPlan')
            ->description('Add plan request')
            ->content(
                MediaType::json()->schema(PlanProfileRequestSchema::ref())
            );
    }

}
