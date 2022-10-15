<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = DB::select('SELECT bills.username,users.name,users.group1,users.group2,COALESCE(transaksi,0)-SUM(bills.bill_amount) AS debit FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username INNER JOIN users ON bills.username = users.username GROUP BY bills.username');
        //SELECT bills.username,users.name,users.group1,users.group2,SUM(transactions.pay-bills.bill_amount) FROM bills INNER JOIN users ON bills.username=users.username INNER JOIN transactions ON bills.username=transactions.username GROUP BY bills.username;
        //SELECT bills.username,(SELECT SUM(transactions.pay) FROM transactions GROUP BY transactions.username)-SUM(bills.bill_amount) FROM bills INNER JOIN transactions ON bills.username=transactions.username GROUP BY bills.username;
        //SELECT bills.username,SUM(bills.bill_amount),w FROM bills LEFT JOIN (SELECT f.username, SUM(f.pay) AS w FROM transactions f GROUP BY f.username) f ON bills.username = f.username GROUP BY bills.username;
        //SELECT bills.username,transaksi-SUM(bills.bill_amount) FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username GROUP BY bills.username
        //SELECT bills.username,COALESCE(transaksi,0)-SUM(bills.bill_amount) FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username GROUP BY bills.username; FIX
        //SELECT bills.username,COALESCE(transaksi,0)-SUM(bills.bill_amount) FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username GROUP BY bills.username; FIX 2
        //SELECT bills.username,bills.bill_id, payments.payment_name, bills.bill_amount,transaksi FROM bills INNER JOIN payments ON bills.payment_id=payments.payment_id LEFT JOIN (SELECT transactions.bill_id, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.bill_id) transactions ON bills.bill_id = transactions.bill_id WHERE bills.username = "user1";Detail Transkasi
        return view('dashboard.transaction.index', [
            'transactions' => $transactions,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}