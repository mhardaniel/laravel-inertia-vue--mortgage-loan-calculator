<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaymentBreakdownController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('loanDetails');
});

Route::controller(PaymentBreakdownController::class)->name('payment-breakdown.')->group(function () {
    Route::get('/payment-breakdown/{loanDetail}', 'show')->name('show');
    Route::post('/payment-breakdown', 'store')->name('store');
});
Route::controller(PaymentBreakdownController::class)->name('extra-payment.')->group(function () {
    Route::get('/extra-payment/{loanDetail}', 'extraShow')->name('show');
    Route::post('/extra-payment', 'extraStore')->name('store');
});
