<?php

use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\BlockedCardController;
use App\Contexts\Cards\Application\Controllers\Web\Card\CardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\CardController as MABCustomerCardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\CustomerController as MABCustomerController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\CardController as MABCardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\PlanController as MABPlanController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\WorkspaceController as MABWorkspaceController;
use App\Contexts\Plans\Application\Controllers\Web\Plan\PlanController;
use App\Contexts\Workspaces\Application\Controllers\Web\Workspace\WorkspaceController;
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
    Route::post('/card', [CardController::class, 'issue'])->name('IssueCard');

    Route::group(['prefix' => '/card/{cardId}'], function () {
        Route::get('/issued', [CardController::class, 'getIssuedCard'])->name('GetIssuedCard');

        Route::post('/complete', [CardController::class, 'complete'])->name('CompleteCard');
        Route::post('/revoke', [CardController::class, 'revoke'])->name('RevokeCard');
        Route::post('/block', [CardController::class, 'block'])->name('BlockCard');

        Route::post('/achievement', [CardController::class, 'addAchievement'])->name('AddAchievement');
        Route::delete('/achievement/{achievementId}', [CardController::class, 'removeAchievement'])->name('RemoveAchievement');
    });

    Route::group(['prefix' => '/blocked-card'], function () {
        Route::post('/{blockedCardId}/unblock', [BlockedCardController::class, 'unblock'])->name('UnblockBlockedCard');
    });
});

Route::group(['prefix' => '/plans/v1'], function () {
    Route::post('/plan', [PlanController::class, 'add'])->name('AddPlan');

    Route::group(['prefix' => '/plan/{planId}'], function () {
        Route::post('/launch', [PlanController::class, 'launch'])->name('LaunchPlan');
        Route::post('/stop', [PlanController::class, 'stop'])->name('StopPlan');
        Route::post('/archive', [PlanController::class, 'archive'])->name('ArchivePlan');

        Route::put('/description', [PlanController::class, 'changeDescription'])->name('ChangePlanDescription');

        Route::post('/requirement', [PlanController::class, 'addRequirement'])->name('AddPlanRequirement');
        Route::delete('/requirement', [PlanController::class, 'removeRequirement'])->name('RemovePlanRequirement');
        Route::put('/requirements', [PlanController::class, 'changeRequirements'])->name('ChangePlanRequirements');
    });
});

Route::group(['prefix' => '/workspaces/v1'], function () {
    Route::group(['prefix' => '/workspace'], function () {
        Route::post('/', [WorkspaceController::class, 'add'])->name('AddWorkspace');
        Route::put('/{workspaceId}/profile', [WorkspaceController::class, 'changeProfile'])->name('ChangeWorkspaceProfile');
    });
});

Route::group(['prefix' => '/mab/v1'], function () {

    Route::get('/workspace', [MABWorkspaceController::class, 'getWorkspaces'])->name('MABWorkspaceListAll');
    Route::post('/workspace', [MABWorkspaceController::class, 'addWorkspace'])->name('MABWorkspaceAdd');

    Route::group(['prefix' => '/workspace/{workspaceId}'], function () {

        Route::get('/', [MABWorkspaceController::class, 'getWorkspace'])->name('MABWorkspaceGet');
        Route::put('/profile', [MABWorkspaceController::class, 'changeWorkspaceProfile'])->name('MABWorkspaceChangeProfile');

        Route::group(['prefix' => '/card'], function () {
            Route::get('/by-code/{codeId}', [MABCardController::class, 'getCardByCode'])->name('MABCustomerGetCardByCode');
            Route::get('/by-id/{cardId}', [MABCardController::class, 'getCardById'])->name('MABCustomerGetCardById');

            Route::post('', [MABCardController::class, 'issue'])->name('MABCustomerIssueCard');
        });

        Route::group(['prefix' => '/card/{cardId}'], function () {
            Route::put('/complete', [MABCardController::class, 'complete'])->name('MABCustomerCompleteCard');
            Route::put('/revoke', [MABCardController::class, 'revoke'])->name('MABCustomerRevokeCard');
            Route::put('/block', [MABCardController::class, 'block'])->name('MABCustomerBlockCard');
            Route::put('/unblock', [MABCardController::class, 'unblock'])->name('MABCustomerUnblockCard');

            Route::post('/achievement', [MABCardController::class, 'noteAchievement'])->name('MABCustomerNoteAchievement');
            Route::delete('/achievement', [MABCardController::class, 'dismissAchievement'])->name('MABCustomerDismissAchievement');
        });

        Route::group(['prefix' => '/plan'], function () {
            Route::get('/', [MABPlanController::class, 'getPlans'])->name('MABPlanListAll');
            Route::post('/', [MABPlanController::class, 'addPlan'])->name('MABPlanAdd');
        });

        Route::group(['prefix' => '/plan/{planId}'], function () {
            Route::get('', [MABPlanController::class, 'getPlan'])->name('MABPlanGet');

            Route::post('/description', [MABPlanController::class, 'setDescription'])->name('MABPlanSetDescription');
            Route::post('/achievements', [MABPlanController::class, 'setAchievements'])->name('MABPlanSetAchievements');
            Route::post('/launch', [MABPlanController::class, 'launchPlan'])->name('MABPlanLaunch');
            Route::post('/stop', [MABPlanController::class, 'stopPlan'])->name('MABPlanStop');
        });
    });

    Route::group(['prefix' => '/customer/{customerId}'], function () {
        Route::get('/code', [MABCustomerController::class, 'generateCode'])->name('MABCustomerCode');
        Route::get('/cards', [MABCustomerCardController::class, 'getCards'])->name('MABCustomerCardListAllCards');

        Route::group(['prefix' => '/card/{cardId}'], function () {
            Route::get('/', [MABCustomerCardController::class, 'getCard'])->name('MABCustomerCard');
            Route::get('/code', [MABCustomerCardController::class, 'generateCardCode'])->name('MABCustomerCardCode');
        });
    });
});
