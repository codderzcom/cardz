<?php

use App\Contexts\Cards\Application\Controllers\Web\Card\CardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/cards/v1'], function () {
    Route::group(['prefix' => '/card'], function () {
        Route::get('{cardId}/code', [CardController::class, 'generateCardCode'])->name('GenerateCardCode');

        Route::post('', [CardController::class, 'issueCard'])->name('IssueCard');

        Route::post('{cardId}/complete', function ($cardId) {
            echo "card $cardId completed";
        })->name('CompleteCard');
        Route::post('{cardId}/revoke', function ($cardId) {
            echo "card $cardId revoked";
        })->name('RevokeCard');
        Route::post('{cardId}/block', function ($cardId) {
            echo "card $cardId blocked";
        })->name('BlockCard');

        Route::post('{cardId}/achievement', function ($cardId) {
            echo "card $cardId achievement noted";
        })->name('AddAchievement');
        Route::delete('{cardId}/achievement/{achievementId}', function ($cardId, $achievementId) {
            echo "card $cardId achievement $achievementId dismissed";
        })->name('RemoveAchievement');

    });

    Route::group(['prefix' => '/blocked-card'], function () {
        Route::post('{blockedCardId}/unblock', function ($blockedCardId) {
            echo "blocked card $blockedCardId unblocked";
        })->name('UnblockBlockedCard');
    });
});
