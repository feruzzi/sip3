<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;
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
    return view('welcome');
});
// Route::get('/payment', function () {
//     return view('dashboard.payment.add');
// });
Route::get('payment', [PaymentController::class, 'index']);
Route::get('payment/add', [PaymentController::class, 'store']);
Route::get('bill/mass_add', [BillController::class, 'mass_store']);