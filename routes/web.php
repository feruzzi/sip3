<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
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
// Route::get('/info/transaction', function () {
//     return view('transaction');
// });
// Route::get('/payment', function () {
//     return view('dashboard.payment.add');
// });
Route::get('info/bill', [PageController::class, 'info_bill']);
Route::get('info/transaction', [PageController::class, 'info_transaction']);
Route::get('change-password', [PageController::class, 'change_password']);
Route::get('payment', [PaymentController::class, 'index']);
Route::get('payment/add', [PaymentController::class, 'store']);
Route::get('bill', [BillController::class, 'index']);
Route::get('bill/mass_add', [BillController::class, 'mass_store']);
Route::get('transaction', [TransactionController::class, 'index']);