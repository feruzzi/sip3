@extends('layouts.main.main')
@section('table_title', 'Tagihan')
@section('content_title', 'Lihat Tagihan Anda')
@section('content')
    <section class="section">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tagihan {{ $name }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive m-3">
                            <table class="table table-hover table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Tagihan</th>
                                        <th>Tagihan</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Dibayar</th>
                                        <th>Kekurangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bills as $bill)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $bill->bill_id }}</td>
                                            <td class="text-bold-500">{{ $bill->payment_name }}</td>
                                            <td>{{ $bill->date }}</td>
                                            <td>
                                                <span
                                                    class="font-extrabold badge bg-light-warning">{{ 'Rp ' . number_format($bill->bill_amount, 2, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="font-extrabold badge bg-light-success">{{ 'Rp ' . number_format($bill->pay, 2, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="font-extrabold badge {{ $bill->debit < 0 ? 'bg-light-danger' : 'bg-light-success' }}">{{ 'Rp ' . number_format($bill->debit, 2, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ url('checkout/' . $bill->bill_id) }}"
                                                    class="btn btn-outline-primary">Bayar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-extrabold">
                                        <td colspan="4">Total</td>
                                        <td>
                                            <span
                                                class="font-extrabold badge bg-light-warning">{{ 'Rp ' . number_format($bill_total, 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="font-extrabold badge bg-light-success">{{ 'Rp ' . number_format($pay_total, 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="font-extrabold badge {{ $debit_total < 0 ? 'bg-light-danger' : 'bg-light-success' }}">{{ 'Rp ' . number_format($debit_total, 2, ',', '.') }}
                                            </span>
                                        </td>
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
