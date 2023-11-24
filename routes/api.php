<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserapiController;
use App\Http\Controllers\Api\PaymentapiController;
use App\Http\Controllers\Api\FinancialapiController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\RoleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::get('/users', [UserapiController::class, 'index'])->name('users.index');

Route::group(['middleware' => ['auth:sanctum', 'throttle:10000,1']], function () {
    //users from list employees GLPI
    Route::get('/users', [UserapiController::class, 'index'])->name('users.index');
   //atualization users from api
   Route::get('/usersupdate', [UserapiController::class, 'usersupdate'])->name('users.usersupdate');
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



    //role list
    Route::get('/role-list', [RoleController::class, 'getList'])->name('role-list');
});