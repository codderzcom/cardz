<?php

use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\BlockedCardController;
use App\Contexts\Cards\Application\Controllers\Web\Card\CardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\CardController as MABCustomerCardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\CustomerController as MABCustomerController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\CardController as MABCardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\PlanController as MABPlanController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\WorkspaceController as MABWorkspaceController;
use App\Contexts\Plans\Application\Controllers\Web\Plan\PlanController;
use App\Contexts\Plans\Application\Controllers\Web\Requirement\RequirementController;
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
        Route::post('complete', [CardController::class, 'complete'])->name('CompleteCard');
        Route::post('revoke', [CardController::class, 'revoke'])->name('RevokeCard');
        Route::post('block', [CardController::class, 'block'])->name('BlockCard');

        Route::post('achievement', [CardController::class, 'addAchievement'])->name('AddAchievement');
        Route::delete('achievement/{achievementId}', [CardController::class, 'removeAchievement'])->name('RemoveAchievement');

        Route::get('requirements', [CardController::class, 'getCardRequirements'])->name('GetCardRequirements');
        Route::get('unachieved-requirements', [CardController::class, 'getCardUnachievedRequirements'])->name('GetCardUnavhievedRequirements');
    });

    Route::group(['prefix' => '/blocked-card'], function () {
        Route::post('{blockedCardId}/unblock', [BlockedCardController::class, 'unblock'])->name('UnblockBlockedCard');
    });
});

Route::group(['prefix' => '/plans/v1'], function () {
    Route::post('/plan', [PlanController::class, 'add'])->name('AddPlan');
    Route::post('/requirement', [RequirementController::class, 'add'])->name('AddRequirement');

    Route::group(['prefix' => '/plan/{planId}'], function () {
        Route::post('launch', [PlanController::class, 'launch'])->name('LaunchPlan');
        Route::post('stop', [PlanController::class, 'stop'])->name('StopPlan');
        Route::post('archive', [PlanController::class, 'archive'])->name('ArchivePlan');
        Route::put('description', [PlanController::class, 'changeDescription'])->name('ChangePlanDescription');

        Route::post('rest-of-requirements', [PlanController::class, 'restOfRequirements'])->name('PlanRestOfRequirements');
        Route::post('is-satisfied-by-requirements', [PlanController::class, 'isSatisfiedByRequirements'])->name('PlanIsSatisfiedByRequirements');
    });

    Route::group(['prefix' => '/requirement/{requirementId}'], function () {
        Route::put('', [RequirementController::class, 'change'])->name('ChangeRequirement');
        Route::delete('', [RequirementController::class, 'remove'])->name('RemoveRequirement');
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

            Route::post('', [MABCardController::class, 'issue'])->name('IssueCard');
            Route::post('{cardId}/complete', [MABCardController::class, 'completeCard'])->name('MABCustomerComplete');
            Route::post('{cardId}/revoke', [MABCardController::class, 'revokeCard'])->name('MABCustomerRevoke');
            Route::post('{cardId}/block', [MABCardController::class, 'blockCard'])->name('MABCustomerBlock');
            Route::post('{cardId}/unblock', [MABCardController::class, 'unblockCard'])->name('MABCustomerUnblock');

            Route::post('{cardId}/achievements', [MABCardController::class, 'addAchievement'])->name('MABCustomerAddAchievement');
            Route::post('{cardId}/achievements/mark', [MABCardController::class, 'markAchievement'])->name('MABCustomerMarkAchievement');
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
            Route::get('{cardId}/achievements', [MABCustomerCardController::class, 'achievements'])->name('MABCustomerCardAchievements');
        });
    });
});
