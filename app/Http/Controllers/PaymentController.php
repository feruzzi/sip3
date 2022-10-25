<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Bills;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Payment::all());
        // $bills = DB::table('bills')
        //     ->select(DB::raw('bills.username,users.name,COUNT(bills.bill_id) AS tagihan'))->join('users', 'bills.username', '=', 'users.username')
        //     ->groupBy('bills.username')
        //     ->get();
        //?? $payments = Payment::all();
        return view('dashboard.payment.index', [
            'set_active' => 'payment',
            //?? 'payments' => $payments
        ]);
    }
    public function ajax_view()
    {
        $payments = Payment::all();
        return Datatables::of($payments)
            ->addIndexColumn()
            ->addColumn('amount', function ($payments) {
                return 'Rp ' . number_format($payments->payment_amount, 2, ',', '.');
            })
            ->addColumn('status', function ($payments) {
                return view('dashboard.payment.style-status')->with('payment', $payments);
            })
            ->addColumn('action', function ($payments) {
                return view('dashboard.payment.action-buttons')->with('payment', $payments);
            })
            ->make(true);
    }
    public function set_payment($id)
    {
        $set = Payment::where('payment_id', $id)->first();
        if ($set->payment_status == "1") {
            Payment::where('payment_id', $id)->update([
                'payment_status' => 0
            ]);
        } else {
            Payment::where('payment_id', $id)->update([
                'payment_status' => 1
            ]);
        }
        return response()->json(['msg' => "Status Pembayaran $id Berhasil Dirubah"]);
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
        $validate = Validator::make($request->all(), [
            'payment_id' => 'required|unique:payments|max:10|min:4',
            'payment_name' => 'required|min:5',
            'payment_amount' => 'required|numeric',
        ], [
            'payment_id.required' => 'ID Pembayaran Wajib Diisi',
            'payment_id.unique' => 'ID Pembayaran Sudah Digunakan',
            'payment_id.min' => 'ID Pembayaran Minimal 4 Digit',
            'payment_id.max' => 'ID Pembayaran Maksimal 10 Digit',
            'payment_name.required' => 'Nama Pembayaran Wajib Diisi',
            'payment_name.min' => 'Nama Pembayaran Minimal 5 Digit',
            'payment_amount.required' => 'Nominal Pembayaran Wajib Diisi',
            'payment_amount.numeric' => 'Nominal Pembayaran Harus Berupa Angka',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "Pembayaran $request->payment_id Gagal Ditambahkan", 'errors' => $validate->errors()]);
        } else {
            Payment::create([
                'payment_id' => $request->payment_id,
                'payment_name' => $request->payment_name,
                'payment_amount' => $request->payment_amount,
                'payment_status' => 1
            ]);
            return response()->json(['msg' => "Pembayaran $request->payment_id Berhasil Ditambahkan"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment, $id)
    {
        $data = Payment::where('payment_id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment, $id)
    {
        // return response()->json($request);
        $validate = Validator::make($request->all(), [
            'payment_name' => 'required|min:5',
            'payment_amount' => 'required|numeric',
        ], [
            'payment_name.required' => 'Nama Pembayaran Wajib Diisi',
            'payment_name.min' => 'Nama Pembayaran Minimal 5 Digit',
            'payment_amount.required' => 'Nominal Pembayaran Wajib Diisi',
            'payment_amount.numeric' => 'Nominal Pembayaran Harus Berupa Angka',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "Pembayaran $id Gagal Diperbarui", 'errors' => $validate->errors()]);
        } else {
            Payment::where('payment_id', $id)->update([
                'payment_name' => $request->payment_name,
                'payment_amount' => $request->payment_amount,
                'payment_status' => 1
            ]);
        }
        return response()->json(['msg' => "Pembayaran $id Berhasil Diperbarui"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment, $id)
    {
        // return response($id);
        try {
            Payment::where('payment_id', $id)->delete();
            return response()->json(['msg' => "Pembayaran $id Berhasil Dihapus"]);
        } catch (Exception $e) {
            return response()->json(['errors' => "Terjadi Kesalahan, Tidak Dapat Menghapus Data"]);
        }
    }
}