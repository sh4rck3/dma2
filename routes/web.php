<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\LandingpageController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\UserwebController;
use App\Http\Controllers\Web\PaymentwebController;
use App\Http\Controllers\Web\FinancialwebController;
use App\Http\Controllers\Web\UseradmwebController;
use App\Http\Controllers\Web\MeetingwebController;
use App\Http\Controllers\Web\SmsadmwebController;
use App\Http\Controllers\Web\PaycheckadmwebController;


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
//birthday  page
Route::get('/birthday', [LandingpageController::class, 'birthday'])->name('birthday');


//pages requiring authentication
Route::group(['midleware' => ['auth:sanctum', 'verified']], function() {
    //firt route autehticated
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    //users page
    Route::get('/users', [UserwebController::class, 'index'])->name('users');
    //inactive users page
    Route::get('/inactiveusers', [UserwebController::class, 'inactiveusers'])->name('inactiveusers');

    //payments
    Route::get('/payments', [PaymentwebController::class, 'index'])->name('payments');
    Route::get('/paymentsimport', [PaymentwebController::class, 'create'])->name('paymentsimport');
    Route::get('/paymentsresult', [PaymentwebController::class, 'show'])->name('paymentsresult');
    Route::get('/paymentshow/{id}', [PaymentwebController::class, 'paymentshow'])->name('paymentshow');
    Route::get('/paycheckview', [PaycheckadmwebController::class, 'index'])->name('paycheckview');
    Route::get('/paycheckviewer', [PaycheckadmwebController::class, 'index'])->name('paycheckviewer');

     //financial
     Route::get('/financial', [FinancialwebController::class, 'index'])->name('financial');
     Route::get('/financialimport', [FinancialwebController::class, 'create'])->name('financialimport');

     //user admin manager
     Route::get('/useradm', [UseradmwebController::class, 'index'])->name('useradm');
     Route::get('/useradmedit/{id}', [UseradmwebController::class, 'edit'])->name('useradmedit');

     //meeting
     Route::get('/meeting', [MeetingwebController::class, 'index'])->name('meeting');
     //sms admin
     Route::get('/smsadmin', [SmsadmwebController::class, 'index'])->name('smsadmin');
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