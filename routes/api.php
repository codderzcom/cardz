<?php

use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\BlockedCardController;
use App\Contexts\Cards\Application\Controllers\Web\Card\CardController;
use App\Contexts\Plans\Application\Controllers\Web\Achievement\AchievementController;
use App\Contexts\Plans\Application\Controllers\Web\Plan\PlanController;
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
        Route::post('{cardId}/complete', [CardController::class, 'completeCard'])->name('CompleteCard');
        Route::post('{cardId}/revoke', [CardController::class, 'revokeCard'])->name('RevokeCard');
        Route::post('{cardId}/block', [CardController::class, 'blockCard'])->name('BlockCard');

        Route::post('{cardId}/achievement', [CardController::class, 'addAchievement'])->name('AddAchievement');
        Route::delete('{cardId}/achievement/{achievementId}', [CardController::class, 'removeAchievement'])->name('RemoveAchievement');
    });

    Route::group(['prefix' => '/blocked-card'], function () {
        Route::post('{blockedCardId}/unblock', [BlockedCardController::class, 'unblockBlockedCard'])->name('UnblockBlockedCard');
    });
});

Route::group(['prefix' => '/plans/v1'], function () {
    Route::group(['prefix' => '/plans'], function () {
        Route::post('', [PlanController::class, 'add'])->name('AddPlan');
        Route::post('{planId}/launch', [PlanController::class, 'launchPlan'])->name('LaunchPlan');
        Route::post('{planId}/stop', [PlanController::class, 'stopPlan'])->name('StopPlan');
        Route::post('{planId}/archive', [PlanController::class, 'archivePlan'])->name('ArchivePlan');
        Route::put('{planId}/description', [PlanController::class, 'changeDescription'])->name('ChangePlanDescription');
    });

    Route::group(['prefix' => '/achievements'], function () {
        Route::post('', [AchievementController::class, 'addAchievement'])->name('AddAchievement');
        Route::put('{achievementId}', [AchievementController::class, 'changeAchievement'])->name('ChangeAchievement');
        Route::delete('{achievementId}', [AchievementController::class, 'removeAchievement'])->name('RemoveAchievement');
    });
});
