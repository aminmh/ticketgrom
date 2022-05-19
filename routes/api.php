<?php

use App\Infrastructure\Facades\AppSettingFacade as AppSetting;
use App\Models\Setting;
use App\Models\Ticket;
use Illuminate\Http\Exceptions\HttpResponseException;
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

Route::any('test', function (Request $request) {

    try {

        return AppSetting::ticketNotifications("");

    } catch (\Exception $th) {
        dd($th);
    }
})/*->middleware('auth:sanctum')*/;


Route::prefix('user')->group(function () {

    Route::get('/', fn (Request $request) => $request->user())->middleware('auth:sanctum');
    Route::post('/setting/set', [\App\Http\Controllers\SettingController::class, 'store']);
    Route::prefix('new')->group(function () {
        Route::post('inbox', [\App\Http\Controllers\InboxController::class, 'store']);
        Route::post('message/to/ticket/{ticket}', [\App\Http\Controllers\MessageController::class, 'sendToTicket']);
    });

    Route::prefix('ticket')->group(function () {
        Route::post('new', [\App\Http\Controllers\TicketController::class, 'store']);
        Route::post('add-to-favorite/{ticket}', [\App\Http\Controllers\TicketController::class, 'markAsFavorite']);
        Route::get('favorites', [\App\Http\Controllers\TicketController::class, 'favorites']);
        Route::get('outbox', [\App\Http\Controllers\TicketController::class, 'outbox']);
        Route::post('rate/{ticket}', [\App\Http\Controllers\TicketController::class, 'rate']);
        Route::post('update/{ticket}', [\App\Http\Controllers\TicketController::class, 'update']);
    });

    Route::prefix('message')->group(function () {
        Route::get('/outbox', [\App\Http\Controllers\MessageController::class, 'outbox']);
        Route::get('/inbox', [\App\Http\Controllers\MessageController::class, 'inbox']);
    });
});

Route::prefix('admin')->group(function () {
    Route::prefix('create')->group(function () {
        Route::post('role', [\App\Http\Controllers\AuthController::class, 'createRole']);
        Route::post('inbox/{department}', [\App\Http\Controllers\InboxController::class, 'store']);
    });

    Route::prefix('grant')->group(function () {
        Route::post('permission/to/role/{role}', [\App\Http\Controllers\AuthController::class, 'grantPermissionToRole']);
        Route::post('role/to/user/{user}', [\App\Http\Controllers\AuthController::class, 'grantRoleToUser']);
    });


    Route::post('/new/message/to/user/{user}', [\App\Http\Controllers\MessageController::class, 'sendToUser']);

    Route::prefix('setting')->group(function () {
        Route::post('{scope}/store', [\App\Http\Controllers\SettingController::class, 'store'])
            ->whereIn('scope', ['app_setting']);
    });
});
