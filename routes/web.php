<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentCallbackController;
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
})->name('login');

// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// });
// Route::get('/info/transaction', function () {
//     return view('transaction');
// });
// Route::get('/payment', function () {
//     return view('dashboard.payment.add');
// });

// Route::get('/transaction/print', function () {
//     return view('dashboard.transaction.print-transaction');
// });
Route::post('auth/login', [AuthController::class, 'authenticate']);
Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

//!!User Siswa
Route::middleware(['auth', 'is_admin:0'])->group(function () {
    Route::get('info/bill', [PageController::class, 'info_bill']);
    Route::get('info/transaction', [PageController::class, 'info_transaction']);
    Route::get('checkout/{id}', [PageController::class, 'checkout']);
    Route::post('pay-checkout/{id}', [PageController::class, 'pay_checkout']);
    Route::post('pay-confrimation/{id}', [PageController::class, 'pay_confirmation']);
    Route::get('change-password', [PageController::class, 'change_password']);
    Route::put('change-password/{id}', [PageController::class, 'update_password']);
});
//!!END User Siswa

Route::middleware(['auth', 'is_admin:1'])->group(function () {
    Route::get('dashboard', [PageController::class, 'dashboard']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/data', [UserController::class, 'ajax_view']);
    Route::post('user/add', [UserController::class, 'store']);
    Route::get('user/{id}/edit', [UserController::class, 'edit']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/delete/{id}', [UserController::class, 'destroy']);
    Route::put('user/set/{id}', [UserController::class, 'set_user']);
    Route::post('user/import', [UserController::class, 'import_users']);

    Route::get('manage-user-group', [UserController::class, 'manage_user_group']);
    Route::post('user/filter', [UserController::class, 'filter_user']);
    Route::put('user/edit/groups', [UserController::class, 'edit_groups']);

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
    // Route::get('bill/free-user', [BillController::class, 'free_user']);
    Route::post('bill/add', [BillController::class, 'store']);
    Route::post('bill/mass_add', [BillController::class, 'mass_store']);
    Route::post('bill/delete/', [BillController::class, 'destroy']);
    Route::put('bill/update/{id}', [BillController::class, 'update']);


    Route::get('transaction', [TransactionController::class, 'index']);
    Route::get('transaction/data', [TransactionController::class, 'ajax_view']);
    Route::post('transaction/payment-list', [TransactionController::class, 'payment_list']);
    Route::post('transaction/add', [TransactionController::class, 'store']);
    Route::get('transaction/detail/{id}', [TransactionController::class, 'detail_transaction']);
    Route::get('transaction/print/{id}', [TransactionController::class, 'print_transaction']);
    Route::get('transaction/bill/print/{id}', [TransactionController::class, 'print_bill']);

    Route::get('detail-transaction', [TransactionController::class, 'detail_index']);
    Route::get('detail-transaction/data', [TransactionController::class, 'detail_ajax_view']);
    Route::get('detail-transaction/{id}/edit', [TransactionController::class, 'edit']);
    Route::put('detail-transaction/{id}', [TransactionController::class, 'update']);
    Route::delete('detail-transaction/delete/{id}', [TransactionController::class, 'destroy']);
});
