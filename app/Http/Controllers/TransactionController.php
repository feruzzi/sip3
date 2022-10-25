<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $transactions = DB::select('SELECT bills.username,users.name,users.group1,users.group2,COALESCE(transaksi,0)-SUM(bills.bill_amount) AS debit FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username INNER JOIN users ON bills.username = users.username GROUP BY bills.username');
        //SELECT bills.username,users.name,users.group1,users.group2,SUM(transactions.pay-bills.bill_amount) FROM bills INNER JOIN users ON bills.username=users.username INNER JOIN transactions ON bills.username=transactions.username GROUP BY bills.username;
        //SELECT bills.username,(SELECT SUM(transactions.pay) FROM transactions GROUP BY transactions.username)-SUM(bills.bill_amount) FROM bills INNER JOIN transactions ON bills.username=transactions.username GROUP BY bills.username;
        //SELECT bills.username,SUM(bills.bill_amount),w FROM bills LEFT JOIN (SELECT f.username, SUM(f.pay) AS w FROM transactions f GROUP BY f.username) f ON bills.username = f.username GROUP BY bills.username;
        //SELECT bills.username,transaksi-SUM(bills.bill_amount) FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username GROUP BY bills.username
        //SELECT bills.username,COALESCE(transaksi,0)-SUM(bills.bill_amount) FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username GROUP BY bills.username; FIX
        //SELECT bills.username,COALESCE(transaksi,0)-SUM(bills.bill_amount) FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username GROUP BY bills.username; FIX 2
        //SELECT bills.username,bills.bill_id, payments.payment_name, bills.bill_amount,transaksi FROM bills INNER JOIN payments ON bills.payment_id=payments.payment_id LEFT JOIN (SELECT transactions.bill_id, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.bill_id) transactions ON bills.bill_id = transactions.bill_id WHERE bills.username = "user1";Detail Transkasi
        return view('dashboard.transaction.index', [
            'set_active' => 'transaction',
            // 'transactions' => $transactions,
        ]);
    }

    public function detail_index()
    {
        return view('dashboard.detail-transaction.index', [
            'set_active' => 'detail_transaction',
            // 'transactions' => $transactions,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ajax_view()
    {
        // $transactions = DB::select('SELECT bills.username,users.name,users.group1,users.group2,COALESCE(transaksi,0)-SUM(bills.bill_amount) AS debit FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username INNER JOIN users ON bills.username = users.username GROUP BY bills.username');
        $transactions = DB::select('SELECT bills.username,users.name,users.group1,group1.group1_name AS group1_name,users.group2,group2.group2_name AS group2_name,COALESCE(transaksi,0)-SUM(bills.bill_amount) AS debit FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username INNER JOIN (users INNER JOIN group1 ON users.group1 = group1.group1_id INNER JOIN group2 ON users.group2 = group2.group2_id) ON bills.username = users.username GROUP BY bills.username');
        return Datatables::of($transactions)
            ->addIndexColumn()
            ->addColumn('description', function ($transactions) {
                return view('dashboard.transaction.style-description-transaction')->with('transaction', $transactions);
            })
            ->addColumn('action', function ($transactions) {
                return view('dashboard.transaction.action-buttons')->with('transaction', $transactions);
            })
            ->make(true);
    }
    public function detail_ajax_view()
    {
        $detail_transactions = DB::table('transactions')->select('transactions.transaction_id', 'transactions.username', 'users.name', 'payments.payment_name', 'transactions.pay', 'transactions.pay_date', 'transactions.note')
            ->join('payments', 'transactions.payment_id', '=', 'payments.payment_id')
            ->join('users', 'transactions.username', '=', 'users.username')
            ->get();
        return Datatables::of($detail_transactions)
            ->addIndexColumn()
            ->addColumn('pay', function ($transactions) {
                return view('dashboard.detail-transaction.pay-style')->with('transaction', $transactions);
            })
            ->addColumn('action', function ($detail_transactions) {
                return view('dashboard.detail-transaction.action-buttons')->with('transaction', $detail_transactions);
            })
            ->make(true);
    }
    public function detail_transaction($id)
    {
        $transaction_details = DB::select('SELECT users.name,bills.bill_id,payments.payment_name,bills.bill_amount,COALESCE(transaksi,0) AS pay,COALESCE(transaksi,0)-bills.bill_amount AS debit FROM bills INNER JOIN payments ON bills.payment_id=payments.payment_id LEFT JOIN (SELECT transactions.bill_id, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.bill_id) transactions ON bills.bill_id=transactions.bill_id INNER JOIN users ON bills.username=users.username  WHERE bills.username="' . $id . '"');
        return response()->json($transaction_details);
        // SELECT bills.username,users.name,users.group1,users.group2,COALESCE(transaksi,0)-SUM(bills.bill_amount) AS debit FROM bills LEFT JOIN (SELECT transactions.username, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.username) transactions ON bills.username = transactions.username INNER JOIN users ON bills.username = users.username WHERE bills.username="nama1" GROUP BY bills.bill_id 
    }
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
        $validate = Validator::make($request->all(), [
            'date' => 'required',
            'pay' => 'required|numeric',
        ], [
            'date.required' => 'Tanggal Wajib Diisi',
            'pay.required' => 'Jumlah Bayar Wajib Diisi',
            'pay.numeric' => 'Jumlah Bayar Harus Berupa Angka',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "Transaksi Gagal Ditambahkan", 'errors' => $validate->errors()]);
        } else {
            $payment_id = Bill::where('bill_id', $request->bill_id)->value('payment_id');
            $prefix = "T" . date('y') . "-";
            $transaction_id = IdGenerator::generate(['table' => 'transactions', 'field' => 'transaction_id', 'length' => 11, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            Transaction::create([
                'transaction_id' => $transaction_id,
                'username' => $request->username,
                'bill_id' => $request->bill_id,
                'payment_id' => $payment_id,
                'pay_date' => $request->date,
                'pay' => $request->pay,
                'admin' => 'admin',
                'note' => $request->note

            ]);
            return response()->json(['msg' => "Tagihan Berhasil dibayarkan"]);
        }
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
    public function edit(Transaction $transaction, $id)
    {
        // return response()->json($id);
        $transaction = Transaction::where('transaction_id', $id)->first();
        return response()->json(['result' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction, $id)
    {
        // return response()->json($request);
        $validate = Validator::make($request->all(), [
            'date' => 'required',
            'pay' => 'required|numeric',
        ], [
            'date.required' => 'Tanggal Wajib Diisi',
            'pay.required' => 'Jumlah Bayar Wajib Diisi',
            'pay.numeric' => 'Jumlah Bayar Harus Berupa Angka',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "Transaksi Gagal Diperbarui", 'errors' => $validate->errors()]);
        } else {
            $payment_id = Bill::where('bill_id', $request->bill_id)->value('payment_id');
            Transaction::where('transaction_id', $id)->update([
                'bill_id' => $request->bill_id,
                'payment_id' => $payment_id,
                'pay_date' => $request->date,
                'pay' => $request->pay,
                'admin' => auth()->user()->username,
                'note' => $request->note

            ]);
            return response()->json(['msg' => "Transaksi Berhasil Diperbarui"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction, $id)
    {
        Transaction::where('transaction_id', $id)->delete();
        return response()->json(['msg' => "Transaksi Berhasil Dihapus"]);
    }
    public function print_transaction($id)
    {
        $transactions = DB::table('transactions')->select('transactions.username', 'users.name', 'payments.payment_name', 'transactions.pay', 'transactions.pay_date', 'transactions.note')
            ->join('payments', 'transactions.payment_id', '=', 'payments.payment_id')
            ->join('users', 'transactions.username', '=', 'users.username')
            ->where('transactions.username', $id)
            ->get();
        return view('dashboard.transaction.print-transaction', [
            'transactions' => $transactions,
        ]);
    }
    public function print_bill($id)
    {
        $transaction_details = DB::select('SELECT users.username,users.name,bills.bill_id,payments.payment_name,bills.bill_amount,COALESCE(transaksi,0) AS pay,COALESCE(transaksi,0)-bills.bill_amount AS debit FROM bills INNER JOIN payments ON bills.payment_id=payments.payment_id LEFT JOIN (SELECT transactions.bill_id, SUM(transactions.pay) AS transaksi FROM transactions GROUP BY transactions.bill_id) transactions ON bills.bill_id=transactions.bill_id INNER JOIN users ON bills.username=users.username  WHERE bills.username="' . $id . '"');
        return view('dashboard.transaction.print-bill', [
            'transactions' => $transaction_details,
        ]);
    }
}