<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\LandingpageController;
use App\Http\Controllers\Web\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//pages not requiring authentication
//home page
Route::get('/', [LandingpageController::class, 'index'])->name('home');
//extensions page
Route::get('/extensions', [LandingpageController::class, 'extensions'])->name('extensions');
//Sms sender page
Route::get('/smssend', [LandingpageController::class, 'smssend'])->name('smssend');


//pages requiring authentication
Route::group(['midleware' => ['auth:sanctum', 'verified']], function() {
    //firt route autehticated
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
});


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });