<?php

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
        Route::post('', function () {
            echo "card issued";
        }, 'IssueCard');
        Route::get('{cardId}/code', function ($cardId) {
            echo "card $cardId code";
        }, 'GenerateCardCode');

        Route::post('{cardId}/achievement', function ($cardId) {
            echo "card $cardId achievement noted";
        }, 'AddAchievement');
        Route::delete('{cardId}/achievement/{achievementId}', function ($cardId, $achievementId) {
            echo "card $cardId achievement $achievementId dismissed";
        }, 'RemoveAchievement');

        Route::post('{cardId}/complete', function ($cardId) {
            echo "card $cardId completed";
        }, 'CompleteCard');
        Route::post('{cardId}/revoke', function ($cardId) {
            echo "card $cardId revoked";
        }, 'RevokeCard');
        Route::post('{cardId}/block', function ($cardId) {
            echo "card $cardId blocked";
        }, 'BlockCard');
    });

    Route::group(['prefix' => '/blocked-card'], function () {
        Route::post('{blockedCardId}/unblock', function ($blockedCardId) {
            echo "blocked card $blockedCardId unblocked";
        }, 'UnblockBlockedCard');
    });
});
