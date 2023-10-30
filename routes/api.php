<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserapiController;

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
});