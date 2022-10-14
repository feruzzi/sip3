<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = DB::table('bills')
            ->select(DB::raw('bills.username,users.name,COUNT(bills.bill_id) AS tagihan'))->join('users', 'bills.username', '=', 'users.username')
            ->groupBy('bills.username')
            ->get();
        return view('dashboard.bill', [
            'payments' => Payment::where('payment_status', 1)->get(),
            'bills' => $bills
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
    public function mass_store(Request $request)
    {
        // dd($request->payment);
        $username = User::where([
            'group1' => $request->group1,
            'group2' => $request->group2
        ])->pluck('username');
        $amount = Payment::where('payment_id', $request->payment)->value('payment_amount');
        foreach ($username as $x => $user) {
            Bill::create([
                'username' => $user,
                'bill_id' => "bl" . $user . $x,
                'payment_id' => $request->payment,
                'date' => "2022-10-10",
                'bill_amount' => $amount,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        //
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
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }
}