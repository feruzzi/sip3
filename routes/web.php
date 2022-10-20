<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// });
// Route::get('/info/transaction', function () {
//     return view('transaction');
// });
// Route::get('/payment', function () {
//     return view('dashboard.payment.add');
// });
Route::get('info/bill', [PageController::class, 'info_bill']);
Route::get('info/transaction', [PageController::class, 'info_transaction']);
Route::get('change-password', [PageController::class, 'change_password']);
Route::get('dashboard', [PageController::class, 'dashboard']);
Route::get('users', [UserController::class, 'index']);
Route::get('payment', [PaymentController::class, 'index']);
Route::get('payment/data', [PaymentController::class, 'ajax_view']);
Route::post('payment/add', [PaymentController::class, 'store']);
Route::delete('payment/delete/{id}', [PaymentController::class, 'destroy']);
Route::put('payment/{id}', [PaymentController::class, 'update']);
Route::put('payment/set/{id}', [PaymentController::class, 'set_payment']);
Route::get('payment/{id}/edit', [PaymentController::class, 'edit']);
Route::get('bill', [BillController::class, 'index']);
Route::get('bill/data', [BillController::class, 'ajax_view']);
Route::get('bill/show/{id}', [BillController::class, 'show_info']);
Route::get('bill/detail/{id}', [BillController::class, 'show']);
Route::post('bill/add', [BillController::class, 'store']);
Route::post('bill/mass_add', [BillController::class, 'mass_store']);
Route::post('bill/delete/', [BillController::class, 'destroy']);
Route::get('transaction', [TransactionController::class, 'index']);