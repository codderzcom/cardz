<?php

namespace Cardz\Support\MobileAppGateway\Integration\Contracts;

interface CardsContextInterface
{
    public function issue(string $planId, string $customerId): string;

    public function complete(string $cardId): string;

    public function revoke(string $cardId): string;

    public function block(string $cardId): string;

    public function unblock(string $cardId): string;

    public function noteAchievement(string $cardId, string $achievementId, string $description): string;

    public function dismissAchievement(string $cardId, string $achievementId): string;
}
