<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $bills = DB::table('bills')
        //     ->select(DB::raw('bills.username,users.name,SUM(bills.bill_amount) total_bill,COUNT(bills.bill_id) AS tagihan'))->join('users', 'bills.username', '=', 'users.username')
        //     ->groupBy('bills.username')
        //     ->get();
        // dd($bills);
        return view('dashboard.bill.index', [
            'set_active' => 'bill',
            'payments' => Payment::where('payment_status', 1)->get(),
            // 'bills' => $bills
        ]);
    }
    public function ajax_view()
    {
        $bills = DB::table('bills')
            ->select(DB::raw('bills.username,users.name,SUM(bills.bill_amount) total_bill,COUNT(bills.bill_id) AS tagihan'))->join('users', 'bills.username', '=', 'users.username')
            ->groupBy('bills.username')
            ->get();
        return Datatables::of($bills)
            ->addIndexColumn()
            ->addColumn('total_bill', function ($bills) {
                return view('dashboard.bill.style-total-bills')->with('bill', $bills);
            })
            ->addColumn('action', function ($bills) {
                return view('dashboard.bill.action-buttons')->with('bill', $bills);
            })
            ->make(true);
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
        // return response()->json($request);
        // Tambah tagihan target username
        // $bill = ['amount' => str_replace(".", "", $request->bill_amount)];
        $validate = Validator::make($request->all(), [
            'bill_amount' => 'required|numeric',
        ], [
            'bill_amount.required' => 'Nominal Pembayaran Wajib Diisi',
            'bill_amount.numeric' => 'Nominal Pembayaran Harus Berupa Angka',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "Pembayaran Gagal Ditambahkan", 'errors' => $validate->errors()]);
        } else {
            $prefix = "TG" . date('y') . "-";
            $bill_id = IdGenerator::generate(['table' => 'bills', 'field' => 'bill_id', 'length' => 11, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            //output: TG2022-00001        
            // $bill_amount = str_replace(".", "", $request->bill_amount);
            Bill::create([
                'username' => $request->username,
                'bill_id' => $bill_id, //random,
                'payment_id' => $request->payment_id,
                'date' => date("Y-m-d"), //date_now(),
                'bill_amount' => $request->bill_amount
            ]);
            return response()->json(['msg' => "Tagihan $request->username Berhasil ditambahkan"]);
        }
    }
    public function mass_store(Request $request)
    {
        // return response()->json([$request->group1, $request->group2, $request->payment_id]);

        // dd($request->payment);
        $username = User::where([
            'group1' => $request->group1,
            'group2' => $request->group2
        ])->pluck('username');
        // return response()->json($username);
        $amount = Payment::where('payment_id', $request->payment_id)->value('payment_amount');
        // return response()->json($amount);
        $prefix = "TG" . date('y') . "-";
        foreach ($username as $x => $user) {
            $bill_id = IdGenerator::generate(['table' => 'bills', 'field' => 'bill_id', 'length' => 11, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            Bill::create([
                'username' => $user,
                'bill_id' => $bill_id, //ganti ke random genareate
                'payment_id' => $request->payment_id,
                'date' => date("Y-m-d"),
                'bill_amount' => $amount,
            ]);
        }
        return response()->json(['msg' => "Tagihan $request->payment_id Berhasil ditambahkan"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill, $id)
    {
        $details = DB::table('bills')->select('bill_id', 'payments.payment_name', 'bills.bill_amount')->join('payments', 'bills.payment_id', '=', 'payments.payment_id')->where('bills.username', $id)->get();
        return response()->json($details);
        // return Datatables::of($details)->make(true);
        // SELECT payments.payment_name,bills.bill_amount FROM bills INNER JOIN payments ON bills.payment_id = payments.payment_id WHERE bills.username="user2";
    }
    public function show_info($id)
    {
        $infos = DB::table('bills')->select('users.username', 'users.name')->join('users', 'bills.username', '=', 'users.username')->where('bills.username', $id)->first();
        return response()->json($infos);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill, $id)
    {
        // $x = [];
        foreach ($request->data_bill as $bill) {
            Bill::where('bill_id', $bill['bill_id'])->update([
                'bill_amount' => $bill['bill_amount'],
            ]);
        }
        // return response()->json($x);
        return response()->json(['msg' => "Tagihan Berhasil Diperbarui"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill, Request $request)
    {
        foreach ($request->bill_id as $bill) {
            Bill::where('bill_id', $bill)->delete();
        }
        return response()->json(['msg' => "Tagihan Berhasil Dihapus"]);
    }
}