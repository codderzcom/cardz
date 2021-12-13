<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class WorkspaceProfileRequestSchema extends SchemaFactory implements Reusable
{
    /**
     * @return SchemaContract
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        $name = Schema::string('name')->description('Workspace (business) title');
        $description = Schema::string('description')->description('Workspace (business) description');
        $address = Schema::string('address')->description('Workspace (business) address');

        return Schema::object('WorkspaceProfile')
            ->description('Workspace profile request')
            ->required($name, $description, $address)
            ->properties($name, $description, $address);
    }

}
