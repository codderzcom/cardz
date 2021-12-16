<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\WorkspaceProfileRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ChangeWorkspaceProfileRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('ChangeWorkspaceProfile')
            ->description('Change workspace profile request')
            ->content(
                MediaType::json()->schema(WorkspaceProfileRequestSchema::ref())
            );
    }

}
