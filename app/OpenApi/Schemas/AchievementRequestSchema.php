<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class AchievementRequestSchema extends SchemaFactory implements Reusable
{
    /**
     * @return SchemaContract
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        $achievementId = Schema::string('achievementId')->format(Schema::FORMAT_UUID)->description('Achievement (requirement) id');
        $description = Schema::string('description')->description('Achievement (requirement) description');

        return Schema::object('Achievement')
            ->description('Achievement request')
            ->required($achievementId, $description)
            ->properties($achievementId, $description);
    }

}
