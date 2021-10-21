<?php

use App\Contexts\Auth\Presentation\Controllers\Http\User\UserController;
use App\Contexts\Cards\Presentation\Controllers\Http\Card\CardController;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\InviteController;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Relation\RelationController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\CardController as MABCustomerCardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\CustomerController as MABCustomerController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\WorkspaceController as MABCustomerWorkspaceController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\CardController as MABCardController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\PlanController as MABPlanController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\WorkspaceController as MABWorkspaceController;
use App\Contexts\Personal\Presentation\Controllers\Http\Person\PersonController;
use App\Contexts\Plans\Presentation\Controllers\Http\Plan\PlanController;
use App\Contexts\Plans\Presentation\Controllers\Http\Requirement\RequirementController;
use App\Contexts\Workspaces\Presentation\Controllers\Http\Workspace\WorkspaceController;
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

Route::group(['prefix' => '/auth/v1'], function () {
    Route::post('/user/register', [UserController::class, 'register'])->name('RegisterUser');
});

Route::group(['prefix' => '/cards/v1'], function () {
    Route::post('/card', [CardController::class, 'issue'])->name('IssueCard');

    Route::group(['prefix' => '/card/{cardId}'], function () {
        Route::post('/complete', [CardController::class, 'complete'])->name('CompleteCard');
        Route::post('/revoke', [CardController::class, 'revoke'])->name('RevokeCard');
        Route::post('/block', [CardController::class, 'block'])->name('BlockCard');
        Route::post('/unblock', [CardController::class, 'unblock'])->name('UnblockBlockedCard');

        Route::post('/achievement', [CardController::class, 'addAchievement'])->name('AddAchievement');
        Route::delete('/achievement/{achievementId}', [CardController::class, 'removeAchievement'])->name('RemoveAchievement');
    });
});

Route::group(['prefix' => '/plans/v1'], function () {
    Route::post('/plan', [PlanController::class, 'add'])->name('AddPlan');

    Route::group(['prefix' => '/plan/{planId}'], function () {
        Route::post('/launch', [PlanController::class, 'launch'])->name('LaunchPlan');
        Route::post('/stop', [PlanController::class, 'stop'])->name('StopPlan');
        Route::post('/archive', [PlanController::class, 'archive'])->name('ArchivePlan');

        Route::put('/description', [PlanController::class, 'changeDescription'])->name('ChangePlanDescription');

        Route::post('/requirement', [RequirementController::class, 'add'])->name('AddPlanRequirement');
        Route::delete('/requirement/{requirementId}', [RequirementController::class, 'remove'])->name('RemovePlanRequirement');
        Route::put('/requirement/{requirementId}', [RequirementController::class, 'change'])->name('ChangePlanRequirement');
    });
});

Route::group(['prefix' => '/workspaces/v1'], function () {
    Route::group(['prefix' => '/workspace'], function () {
        Route::post('/', [WorkspaceController::class, 'add'])->name('AddWorkspace');
        Route::put('/{workspaceId}/profile', [WorkspaceController::class, 'changeProfile'])->name('ChangeWorkspaceProfile');
    });
});

Route::group(['prefix' => '/collaboration/v1'], function () {
    Route::post('/relation/leave', [RelationController::class, 'leave'])->name('LeaveRelation');

    Route::post('/invite', [InviteController::class, 'propose'])->name('ProposeInvite');
    Route::post('/invite/{inviteId}/accept', [InviteController::class, 'accept'])->name('AcceptInvite');
    Route::post('/invite/{inviteId}/discard', [InviteController::class, 'discard'])->name('DiscardInvite');
});

Route::group(['prefix' => '/personal/v1/person/{personId}'], function () {
    Route::put('/name', [PersonController::class, 'changeName'])->name('ChangePersonName');
});

Route::group(['prefix' => '/mab/v1'], function () {
    Route::post('/customer/get-token', [MABCustomerController::class, 'getToken'])->name('MABCustomerGetToken');
    Route::post('/customer/register', [MABCustomerController::class, 'register'])->name('MABCustomerRegister');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/workspace', [MABWorkspaceController::class, 'getWorkspacesForKeeper'])->name('MABWorkspaceListAll');
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
                Route::post('/', [MABPlanController::class, 'add'])->name('MABPlanAdd');
            });

            Route::group(['prefix' => '/plan/{planId}'], function () {
                Route::get('/', [MABPlanController::class, 'getPlan'])->name('MABPlanGet');

                Route::put('/description', [MABPlanController::class, 'changeDescription'])->name('MABPlanChangeDescription');
                Route::put('/launch', [MABPlanController::class, 'launch'])->name('MABPlanLaunch');
                Route::put('/stop', [MABPlanController::class, 'stop'])->name('MABPlanStop');
                Route::put('/archive', [MABPlanController::class, 'archive'])->name('MABPlanStop');

                Route::post('/requirement', [MABPlanController::class, 'addRequirement'])->name('MABPlanAddRequirement');
                Route::delete('/requirement/{requirementId}', [MABPlanController::class, 'removeRequirement'])->name('MABPlanRemoveRequirement');
                Route::put('/requirement/{requirementId}', [MABPlanController::class, 'changeRequirement'])->name('MABPlanChangeRequirement');
            });
        });

        Route::group(['prefix' => '/customer'], function () {
            Route::get('/code', [MABCustomerController::class, 'generateCode'])->name('MABCustomerCode');
            Route::get('/card', [MABCustomerCardController::class, 'getCards'])->name('MABCustomerCardListAll');

            Route::get('/workspaces', [MABCustomerWorkspaceController::class, 'all'])->name('MABCustomerWorkspaceListAll');

            Route::group(['prefix' => '/card/{cardId}'], function () {
                Route::get('/', [MABCustomerCardController::class, 'getCard'])->name('MABCustomerCard');
                Route::get('/code', [MABCustomerCardController::class, 'generateCardCode'])->name('MABCustomerCardCode');
            });
        });
    });
});

