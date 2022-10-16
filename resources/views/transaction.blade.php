@extends('layouts.main.main')
@section('table_title', 'Pembayaran')
@section('content_title', 'Pembayaran')

@section('content')
    <section class="section">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pembayaran {{ $name }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Transaksi</th>
                                        <th>Tagihan</th>
                                        <th>Membayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $transaction->transaction_id }}</td>
                                            <td>{{ $transaction->payment_name }}</td>
                                            <td class="text-success">{{ $transaction->pay }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-extrabold">
                                        <td colspan="3">Total</td>
                                        <td class="text-success font-extrabold">{{ $transaction_total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
