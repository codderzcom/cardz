<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class CustomerWorkspaceResponseSchema extends SchemaFactory implements Reusable
{
    use SchemaFakerTrait;

    public function build(): SchemaContract
    {
        $workspaceId = Schema::string('workspaceId')
            ->format(Schema::FORMAT_UUID)
            ->nullable(false)
            ->description('Workspace Id');

        $name = Schema::string('name')
            ->nullable(false)
            ->description('Workspace (business) name')
            ->example($this->company());

        $description = Schema::string('description')
            ->nullable(false)
            ->description('Workspace (business) description')
            ->example($this->text());

        $address = Schema::string('address')
            ->nullable(false)
            ->description('Workspace (business) address')
            ->example($this->address());

        return Schema::object('CustomerWorkspace')
            ->properties($workspaceId, $name, $description, $address)
            ->required($workspaceId, $name, $description, $address);
    }

}
