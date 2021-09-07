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
        Route::get('issued', [CardController::class, 'getIssuedCard'])->name('GetIssuedCard');

        Route::post('complete', [CardController::class, 'complete'])->name('CompleteCard');
        Route::post('revoke', [CardController::class, 'revoke'])->name('RevokeCard');
        Route::post('block', [CardController::class, 'block'])->name('BlockCard');

        Route::post('achievement', [CardController::class, 'addAchievement'])->name('AddAchievement');
        Route::delete('achievement/{achievementId}', [CardController::class, 'removeAchievement'])->name('RemoveAchievement');
    });

    Route::group(['prefix' => '/blocked-card'], function () {
        Route::post('{blockedCardId}/unblock', [BlockedCardController::class, 'unblock'])->name('UnblockBlockedCard');
    });
});

Route::group(['prefix' => '/plans/v1'], function () {
    Route::post('/plan', [PlanController::class, 'add'])->name('AddPlan');

    Route::group(['prefix' => '/plan/{planId}'], function () {
        Route::post('launch', [PlanController::class, 'launch'])->name('LaunchPlan');
        Route::post('stop', [PlanController::class, 'stop'])->name('StopPlan');
        Route::post('archive', [PlanController::class, 'archive'])->name('ArchivePlan');

        Route::put('description', [PlanController::class, 'changeDescription'])->name('ChangePlanDescription');

        Route::post('requirement', [PlanController::class, 'addRequirement'])->name('AddPlanRequirement');
        Route::delete('requirement', [PlanController::class, 'removeRequirement'])->name('RemovePlanRequirement');
        Route::put('requirements', [PlanController::class, 'changeRequirements'])->name('ChangePlanRequirements');
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
        Route::post('{workspaceId}/profile', [MABWorkspaceController::class, 'changeProfile'])->name('MABWorkspaceChangeProfile');

        Route::group(['prefix' => '{workspaceId}/card'], function () {
            Route::get('by-code/{codeId}', [MABCardController::class, 'getCardByCode'])->name('MABCustomerGetByCode');
            Route::get('by-id/{cardId}', [MABCardController::class, 'getCard'])->name('MABCustomerGetByCode');
        });

        Route::group(['prefix' => '{workspaceId}/card/{cardId}'], function () {
            Route::post('', [MABCardController::class, 'issue'])->name('MABCustomerIssueCard');
            Route::post('complete', [MABCardController::class, 'complete'])->name('MABCustomerCompleteCard');
            Route::post('revoke', [MABCardController::class, 'revoke'])->name('MABCustomerRevokeCard');
            Route::post('block', [MABCardController::class, 'block'])->name('MABCustomerBlockCard');
            Route::post('unblock', [MABCardController::class, 'unblock'])->name('MABCustomerUnblockCard');

            Route::post('achievement', [MABCardController::class, 'noteAchievement'])->name('MABCustomerNoteAchievement');
            Route::delete('achievement', [MABCardController::class, 'dismissAchievement'])->name('MABCustomerDismissAchievement');
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
    });

    Route::group(['prefix' => '/customer'], function () {
        Route::get('{customerId}/code', [MABCustomerController::class, 'generateCode'])->name('MABCustomerCode');

        Route::group(['prefix' => '{customerId}/card'], function () {
            Route::get('', [MABCustomerCardController::class, 'listAllCards'])->name('MABCustomerCardListAllCards');

            Route::get('{cardId}', [MABCustomerCardController::class, 'getCard'])->name('MABCustomerCard');
            Route::get('{cardId}/code', [MABCustomerCardController::class, 'generateCardCode'])->name('MABCustomerCardCode');
        });
    });
});
