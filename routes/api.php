<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserapiController;
use App\Http\Controllers\Api\PaymentapiController;
use App\Http\Controllers\Api\FinancialapiController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\MeetingapiController;
use App\Http\Controllers\Api\PaycheckadmapiController;
use App\Http\Controllers\Api\SmsadmapiContrroller;
use App\Http\Controllers\Api\LegalapiController;
use App\Http\Controllers\Api\ApiwhatsController;
use App\Http\Controllers\Api\ChatapiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//users from list employees GLPI
Route::get('/userslanding', [UserapiController::class, 'userslanding'])->name('users.userslanding');
Route::get('/birthdaylanding', [UserapiController::class, 'birthdaylanding'])->name('users.birthdaylanding');

Route::get('/paymentmesref', [PaycheckadmapiController::class, 'paymentmesref']);


Route::post('/whatsapp/statusconect', [ApiwhatsController::class, 'statusconect']);
Route::post('/whatsapp/qrcode', [ApiwhatsController::class, 'qrcode']);
Route::post('/whatsapp/status', [ApiwhatsController::class, 'status']);
Route::post('/whatsapp/mensagem', [ApiwhatsController::class, 'mensagem']);
Route::post('/whatsapp/call', [ApiwhatsController::class, 'call']);
Route::post('/whatsapp/delete', [ApiwhatsController::class, 'delete']);
Route::post('/whatsapp/presenca', [ApiwhatsController::class, 'presenca']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::get('/users', [UserapiController::class, 'index'])->name('users.index');

Route::group(['middleware' => ['auth:sanctum', 'throttle:10000,1']], function () {
    //users from list employees GLPI
    Route::get('/users', [UserapiController::class, 'index'])->name('users.index');
   //atualization users from api
   Route::get('/usersupdate', [UserapiController::class, 'usersupdate']);
   //inactive users from glpi
   Route::get('/inactiveusers', [UserapiController::class, 'inactiveusers'])->name('users.inactiveusers');

     //payments
     Route::get('/payment', [PaymentapiController::class, 'index'])->name('payment');
     Route::post('/payment/store', [PaymentapiController::class, 'store'])->name('payment.store');
     Route::get('/paymentuser', [PaymentapiController::class, 'paymentuser'])->name('paymentuser');
     Route::get('/paymentuser/show/{id}', [PaymentapiController::class, 'show'])->name('paymentuser.show');
     Route::get('/payment/confirm/{id}', [PaymentapiController::class, 'confirm'])->name('confirm');

       //financial
    Route::get('/financialindex', [FinancialapiController::class, 'index'])->name('financialindex');
    Route::post('/financial/store', [FinancialapiController::class, 'store'])->name('financial.store');
    Route::delete('/financial/destroy/{id}', [FinancialapiController::class, 'destroy'])->name('financial.destroy');

    //user admin manager
    Route::put('/users', [UserapiController::class, 'update']);
    Route::delete('/users/destroy/{id}', [UserapiController::class, 'destroy'])->name('users.destroy');
    Route::put('/useradmedit/{id}', [UserapiController::class, 'edit'])->name('useradmedit');
    Route::put('/useradmupdate/{id}', [UserapiController::class, 'update'])->name('useradmupdate');

    //meeting
    //Route::get('/meeting', [MeetingapiController::class, 'index'])->name('meeting');
    Route::post('/meeting/store', [MeetingapiController::class, 'store'])->name('meeting.store');

    //role list
    Route::get('/role-list', [RoleController::class, 'getList'])->name('role-list');

    Route::post('/sendsms', [SmsadmapiContrroller::class, 'sendsms']);
    Route::get('/responsesms', [SmsadmapiContrroller::class, 'responsesms']);
    
    //paycheck
    Route::get('/paycheckadm', [PaycheckadmapiController::class, 'index']);

    //legal
    Route::get('/legal', [LegalapiController::class, 'index'])->name('legal');
    Route::post('/legal/store', [LegalapiController::class, 'store'])->name('legal.store');

    //chat
    Route::get('/contacts', [ChatapiController::class, 'index'])->name('chat.contacts');
    Route::get('/contacts/{ticket}', [ChatapiController::class, 'show'])->name('chat.show');
    Route::get('/messages/{ticket}', [ChatapiController::class, 'messages'])->name('chat.messages');
});