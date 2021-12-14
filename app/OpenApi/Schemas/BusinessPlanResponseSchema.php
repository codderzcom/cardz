<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class BusinessPlanResponseSchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        $planId = Schema::string('planId')->format(Schema::FORMAT_UUID)->description('Plan Id');
        $workspaceId = Schema::string('workspaceId')->format(Schema::FORMAT_UUID)->description('Workspace Id');
        $description = Schema::string('description')->description('Plan description');

        $isLaunched = Schema::boolean('isLaunched')->description('Whether the plan is launched');
        $isStopped = Schema::boolean('isStopped')->description('Whether the plan is stopped');
        $isArchived = Schema::boolean('isArchived')->description('Whether the plan is archived');

        $requirement = Schema::object()->properties(
            Schema::string('requirementId')->format(Schema::FORMAT_UUID)->description('Requirement id'),
            Schema::string('description')->description('Requirement description'),
        );
        $requirements = Schema::array('requirements')->items($requirement)->description('All requirements');

        return Schema::object('BusinessPlan')->properties(
            $planId, $workspaceId, $description, $isLaunched, $isStopped, $isArchived, $requirements
        );
    }

}
