<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class BusinessCardResponseSchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        $cardId = Schema::string('cardId')->format(Schema::FORMAT_UUID)->description('Card Id');
        $planId = Schema::string('planId')->format(Schema::FORMAT_UUID)->description('Plan Id');
        $customerId = Schema::string('customerId')->format(Schema::FORMAT_UUID)->description('Customer Id');

        $isIssued = Schema::boolean('isIssued')->description('Whether the card is issued');
        $isSatisfied = Schema::boolean('isSatisfied')->description('Whether all the requirements to receive a bonus are satisfied');
        $isCompleted = Schema::boolean('isCompleted')->description('Whether the customer has received the bonus for this card');
        $isRevoked = Schema::boolean('isRevoked')->description('Whether the card has been revoked');
        $isBlocked = Schema::boolean('isBlocked')->description('Whether the card has been blocked');

        $achievement = Schema::object()->properties(
            Schema::string('achievementId')->format(Schema::FORMAT_UUID)->description('Achievement Id = corresponding requirement id'),
            Schema::string('description')->description('Achievement description = corresponding requirement description'),
        );
        $achievements = Schema::array('achievements')->items($achievement)->description('Achieved requirements');

        $requirement = Schema::object()->properties(
            Schema::string('requirementId')->format(Schema::FORMAT_UUID)->description('Requirement id'),
            Schema::string('description')->description('Requirement description'),
        );
        $requirements = Schema::array('requirements')->items($requirement)->description('All requirements');

        return Schema::object('BusinessCard')->properties(
            $cardId, $planId, $customerId, $isIssued, $isSatisfied, $isCompleted, $isRevoked, $isBlocked, $achievements, $requirements
        );
    }

}
