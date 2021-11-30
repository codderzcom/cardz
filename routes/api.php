<?php

/*
use Cardz\Core\Cards\Presentation\Controllers\Http\Card\CardController;
use Cardz\Support\Collaboration\Presentation\Controllers\Http\Invite\InviteController;
use Cardz\Support\Collaboration\Presentation\Controllers\Http\Relation\RelationController;
use Cardz\Generic\Identity\Presentation\Controllers\Http\User\UserController;
*/

/*
use Cardz\Core\Personal\Presentation\Controllers\Http\Person\PersonController;
use Cardz\Core\Plans\Presentation\Controllers\Http\Plan\PlanController;
use Cardz\Core\Plans\Presentation\Controllers\Http\Requirement\RequirementController;
use Cardz\Core\Workspaces\Presentation\Controllers\Http\Workspace\WorkspaceController;
use Illuminate\Http\Request;
*/

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


/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/identity/v1'], function () {
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

*/
