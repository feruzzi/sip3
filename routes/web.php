<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGroupController;
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
//!!User Siswa
Route::get('info/bill', [PageController::class, 'info_bill']);
Route::get('info/transaction', [PageController::class, 'info_transaction']);
Route::get('change-password', [PageController::class, 'change_password']);
//!!END User Siswa


Route::get('dashboard', [PageController::class, 'dashboard']);

Route::get('users', [UserController::class, 'index']);
Route::get('users/data', [UserController::class, 'ajax_view']);
Route::post('user/add', [UserController::class, 'store']);
Route::get('user/{id}/edit', [UserController::class, 'edit']);
Route::put('user/{id}', [UserController::class, 'update']);
Route::delete('user/delete/{id}', [UserController::class, 'destroy']);
Route::put('user/set/{id}', [UserController::class, 'set_user']);

Route::get('user-group', [UserGroupController::class, 'index']);

Route::get('group1/data', [UserGroupController::class, 'group1_view']);
Route::post('group1/add', [UserGroupController::class, 'group1_store']);
Route::put('group1/set/{id}', [UserGroupController::class, 'group1_set']);
Route::get('group1/{id}/edit', [UserGroupController::class, 'group1_edit']);
Route::put('group1/{id}', [UserGroupController::class, 'group1_update']);
Route::delete('group1/delete/{id}', [UserGroupController::class, 'group1_destroy']);

Route::get('group2/data', [UserGroupController::class, 'group2_view']);
Route::post('group2/add', [UserGroupController::class, 'group2_store']);
Route::put('group2/set/{id}', [UserGroupController::class, 'group2_set']);
Route::get('group2/{id}/edit', [UserGroupController::class, 'group2_edit']);
Route::put('group2/{id}', [UserGroupController::class, 'group2_update']);
Route::delete('group2/delete/{id}', [UserGroupController::class, 'group2_destroy']);

Route::get('group2/data', [UserGroupController::class, 'group2_view']);

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
Route::post('bill/update/{id}', [BillController::class, 'update']);


Route::get('transaction', [TransactionController::class, 'index']);