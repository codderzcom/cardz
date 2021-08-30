<?php

use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\BlockedCardController;
use App\Contexts\Cards\Application\Controllers\Web\Card\CardController;
use App\Contexts\Plans\Application\Controllers\Web\Achievement\AchievementController;
use App\Contexts\Plans\Application\Controllers\Web\Plan\PlanController;
use App\Contexts\Workspaces\Application\Controllers\Web\Workspace\WorkspaceController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\WorkspaceController as MABWorkspaceController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Plan\PlanController as MABPlanController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Card\CardController as MABCardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\CustomerController as MABCustomerController;
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
        Route::get('{cardId}/code', [CardController::class, 'generateCode'])->name('GenerateCardCode');

        Route::post('', [CardController::class, 'issue'])->name('IssueCard');
        Route::post('{cardId}/complete', [CardController::class, 'complete'])->name('CompleteCard');
        Route::post('{cardId}/revoke', [CardController::class, 'revoke'])->name('RevokeCard');
        Route::post('{cardId}/block', [CardController::class, 'block'])->name('BlockCard');

        Route::post('{cardId}/achievement', [CardController::class, 'addAchievement'])->name('AddAchievement');
        Route::delete('{cardId}/achievement/{achievementId}', [CardController::class, 'removeAchievement'])->name('RemoveAchievement');
    });

    Route::group(['prefix' => '/blocked-card'], function () {
        Route::post('{blockedCardId}/unblock', [BlockedCardController::class, 'unblock'])->name('UnblockBlockedCard');
    });
});

Route::group(['prefix' => '/plans/v1'], function () {
    Route::group(['prefix' => '/plan'], function () {
        Route::post('', [PlanController::class, 'add'])->name('AddPlan');
        Route::post('{planId}/launch', [PlanController::class, 'launch'])->name('LaunchPlan');
        Route::post('{planId}/stop', [PlanController::class, 'stop'])->name('StopPlan');
        Route::post('{planId}/archive', [PlanController::class, 'archive'])->name('ArchivePlan');
        Route::put('{planId}/description', [PlanController::class, 'changeDescription'])->name('ChangePlanDescription');
    });

    Route::group(['prefix' => '/achievement'], function () {
        Route::post('', [AchievementController::class, 'add'])->name('AddAchievement');
        Route::put('{achievementId}', [AchievementController::class, 'change'])->name('ChangeAchievement');
        Route::delete('{achievementId}', [AchievementController::class, 'remove'])->name('RemoveAchievement');
    });
});

Route::group(['prefix' => '/workspaces/v1'], function () {
    Route::group(['prefix' => '/workspace'], function () {
        Route::post('', [WorkspaceController::class, 'add'])->name('AddWorkspace');
        Route::post('{workspaceId}/profile', [WorkspaceController::class, 'changeProfile'])->name('ChangeWorkspaceProfile');
    });
});


Route::group(['prefix' => '/mab/v1'], function () {
    Route::group(['prefix' => '/workspace'], function () {
        Route::get('', [MABWorkspaceController::class, 'listAll'])->name('MABWorkspaceListAll');
        Route::get('{workspaceId}', [MABWorkspaceController::class, 'getWorkspace'])->name('MABWorkspaceGet');

        Route::post('', [MABWorkspaceController::class, 'add'])->name('MABWorkspaceAdd');
        Route::post('{workspaceId}/profile', [WorkspaceController::class, 'changeProfile'])->name('MABWorkspaceChangeProfile');
    });

    Route::group(['prefix' => '/plan'], function () {
        Route::get('', [MABPlanController::class, 'listAll'])->name('MABPlanListAll');
        Route::get('{planId}', [MABPlanController::class, 'getPlan'])->name('MABPlanGet');

        Route::post('', [MABPlanController::class, 'add'])->name('MABPlanAdd');
        Route::post('{planId}/description', [MABPlanController::class, 'setDescription'])->name('MABPlanSetDescription');
        Route::post('{planId}/achievements', [MABPlanController::class, 'setAchievements'])->name('MABPlanSetAchievements');
        Route::post('{planId}/launch', [MABPlanController::class, 'launch'])->name('MABPlanLaunch');
        Route::post('{planId}/stop', [MABPlanController::class, 'stop'])->name('MABPlanStop');
    });

    Route::group(['prefix' => '/customer'], function () {
        Route::get('{customerId}/code', [MABCustomerController::class, 'generateCode'])->name('MABCustomerGenerateCode');
        Route::get('{customerId}/listAllCards', [MABCustomerController::class, 'listAllCards'])->name('MABCustomerListAllCards');
    });

    Route::group(['prefix' => '/card'], function () {
        Route::get('{cardId}', [MABCardController::class, 'getCard'])->name('MABCardGet');
        Route::get('{cardId}/code', [MABCardController::class, 'generateCode'])->name('MABCardGenerateCode');
        Route::get('{cardId}/achievement', [MABCardController::class, 'listAllAchievements'])->name('MABCardListAllAchievements');

        Route::post('', [MABCardController::class, 'issue'])->name('IssueCard');
        Route::post('{cardId}/complete', [MABCardController::class, 'completeCard'])->name('MABCardComplete');
        Route::post('{cardId}/revoke', [MABCardController::class, 'revokeCard'])->name('MABCardRevoke');
        Route::post('{cardId}/block', [MABCardController::class, 'blockCard'])->name('MABCardBlock');
        Route::post('{cardId}/unblock', [MABCardController::class, 'unblockCard'])->name('MABCardUnblock');

        Route::post('{cardId}/achievement', [MABCardController::class, 'addAchievement'])->name('AddAchievement');
        Route::post('{cardId}/achievement/mark', [MABCardController::class, 'markAchievement'])->name('MABCardMarkAchievement');
    });

});
