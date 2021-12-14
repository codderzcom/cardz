<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class CustomerWorkspaceResponseSchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        $workspaceId = Schema::string('workspaceId')->format(Schema::FORMAT_UUID)->description('Workspace Id');
        $name = Schema::string('name')->description('Workspace (business) name');
        $description = Schema::string('description')->description('Workspace (business) description');
        $address = Schema::string('address')->description('Workspace (business) address');

        return Schema::object('CustomerWorkspace')->properties($workspaceId, $name, $description, $address);
    }

}
