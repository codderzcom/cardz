<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class BusinessWorkspaceResponseSchema extends SchemaFactory implements Reusable
{
    use SchemaFakerTrait;

    public function build(): SchemaContract
    {
        $workspaceId = Schema::string('workspaceId')
            ->format(Schema::FORMAT_UUID)
            ->nullable(false)
            ->description('Workspace Id');

        $keeperId = Schema::string('keeperId')
            ->format(Schema::FORMAT_UUID)
            ->nullable(false)
            ->description('Keeper Id');

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

        return Schema::object('BusinessWorkspace')
            ->properties($workspaceId, $keeperId, $name, $description, $address)
            ->required($workspaceId, $keeperId, $name, $description, $address);
    }

}
