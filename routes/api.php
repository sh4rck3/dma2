<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserapiController;
use App\Http\Controllers\Api\PaymentapiController;

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

});