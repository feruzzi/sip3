<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Bill;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class PageController extends Controller
{
    public function info_bill()
    {
        $user = "user2";
        // $bills = DB::select('SELECT users.name,bills.bill_id,payments.payment_name,bills.bill_amount,COALESCE(transaksi,0) AS pay,COALESCE(transaksi,0)-bills.bill_amount AS debit FROM bills INNER JOIN payments ON bills.payment_id=payments.payment_id LEFT JOIN (SELECT transactions.bill_id, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.bill_id) transactions ON bills.bill_id=transactions.bill_id INNER JOIN users ON bills.username=users.username  WHERE bills.username="user2"
        // ');
        $bills = DB::table('bills')
            ->select('users.name', 'bills.bill_id', 'payments.payment_name', 'bills.bill_amount', 'bills.date', DB::raw('COALESCE(transaksi,0) AS pay,COALESCE(transaksi,0)-bills.bill_amount AS debit'))
            ->join('payments', 'bills.payment_id', '=', 'payments.payment_id')
            ->leftJoin(DB::raw('(SELECT transactions.bill_id, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.bill_id) transactions'), 'bills.bill_id', '=', 'transactions.bill_id')
            ->join('users', 'bills.username', '=', 'users.username')
            ->where('bills.username', '=', $user)
            ->get();
        // $bills = DB::table('bills')
        //     ->select(DB::raw('users.name,bills.bill_id,bills.date,payments.payment_name,bills.bill_amount'))->join('users', 'bills.username', '=', 'users.username')
        //     ->join('payments', 'bills.payment_id', '=', 'payments.payment_id')
        //     ->where('bills.username', '=', $user)
        //     ->get();
        // $bills = Bill::where('username', '=', 'user1')->get();
        // dd($bills->sum('bill_amount'));
        // dd($bills);
        return view('bill', [
            'set_active' => 'bill',
            'bills' => $bills,
            'name' => $bills->value('name'),
            'bill_total' => $bills->sum('bill_amount'),
            'pay_total' => $bills->sum('pay'),
            'debit_total' => $bills->sum('debit')
        ]);
    }
    public function info_transaction()
    {
        $user = "user2";
        $transactions = DB::table('transactions')
            ->select(DB::raw('transactions.transaction_id,payments.payment_name,transactions.pay,users.name'))->join('users', 'transactions.username', '=', 'users.username')
            ->join('payments', 'transactions.payment_id', '=', 'payments.payment_id')
            ->where('transactions.username', '=', $user)
            ->get();
        return view('transaction', [
            'set_active' => 'transaction',
            'transactions' => $transactions,
            'name' => $transactions->value('name'),
            'transaction_total' => $transactions->sum('pay')
        ]);
    }
    public function change_password()
    {
        $user = "user2";
        return view('change-password', [
            'set_active' => 'change_password',
            'name' => User::where('username', '=', $user)->value('name'),
        ]);
    }
    public function dashboard()
    {
        $total_users = User::where('level', '=', 1)->get();
        $total_bills = Bill::sum('bill_amount');
        $total_pay = Transaction::sum('pay');
        $bills = DB::table('bills')
            ->select('users.name', 'bills.bill_id', 'payments.payment_name', 'bills.bill_amount', 'bills.date', DB::raw('COALESCE(transaksi,0) AS pay,COALESCE(transaksi,0)-bills.bill_amount AS debit'))
            ->join('payments', 'bills.payment_id', '=', 'payments.payment_id')
            ->leftJoin(DB::raw('(SELECT transactions.bill_id, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.bill_id) transactions'), 'bills.bill_id', '=', 'transactions.bill_id')
            ->join('users', 'bills.username', '=', 'users.username')
            ->get();
        $bill_off = $bills->where('debit', '>=', 0)->count();
        $bill_on = $bills->where('debit', '<', 0)->count();
        return view('dashboard.index', [
            'set_active' => 'dashboard',
            'total_users' => $total_users->count(),
            'total_bills' => $total_bills,
            'total_pay' => $total_pay,
            'bill_off' => $bill_off,
            'bill_on' => $bill_on
        ]);
        // dd($total_users->count());
    }
}