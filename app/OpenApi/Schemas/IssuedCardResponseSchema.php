<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class IssuedCardResponseSchema extends SchemaFactory implements Reusable
{
    use SchemaFakerTrait;

    public function build(): SchemaContract
    {
        $cardId = Schema::string('cardId')
            ->format(Schema::FORMAT_UUID)
            ->description('Card Id');

        $planId = Schema::string('planId')
            ->format(Schema::FORMAT_UUID)
            ->description('Plan Id');

        $customerId = Schema::string('customerId')
            ->format(Schema::FORMAT_UUID)
            ->description('Customer Id');

        $description = Schema::string('description')
            ->description('Card (plan) description')
            ->example($this->faker()->text());

        $satisfied = Schema::boolean('satisfied')
            ->description('Whether all requirements to receive a bonus are satisfied');

        $completed = Schema::boolean('completed')
            ->description('Whether customer has received the bonus for this card');

        $achievement = Schema::object()->properties(
            Schema::string('achievementId')
                ->format(Schema::FORMAT_UUID)
                ->description('Achievement Id = corresponding requirement id'),

            Schema::string('description')
                ->description('Achievement description = corresponding requirement description')
                ->example($this->text()),
        );
        $achievements = Schema::array('achievements')
            ->items($achievement)
            ->description('Achieved requirements')
            ->example($this->text());

        $requirement = Schema::object()->properties(
            Schema::string('requirementId')
                ->format(Schema::FORMAT_UUID)->description('Requirement id'),

            Schema::string('description')
                ->description('Requirement description')
                ->example($this->text()),
        );
        $requirements = Schema::array('requirements')
            ->items($requirement)
            ->description('All requirements');

        return Schema::object('IssuedCard')
            ->properties($cardId, $planId, $customerId, $description, $satisfied, $completed, $achievements, $requirements);
    }

}
