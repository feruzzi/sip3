@extends('layouts.dashboard.dashboard')
@push('header-js')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush
@push('footer-js')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pembayaran</h3>
                <p class="text-subtitle text-muted">Informasi Data Pembayaran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('payment') }}">Pembayaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="col-12">
            <div class="d-flex mb-3">
                <a class="ms-auto btn btn-primary">Tambah Pembayaran Baru</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Pembayaran</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Pembayaran</th>
                                    <th>Pembayaran</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->payment_id }}</td>
                                        <td>{{ $payment->payment_name }}</td>
                                        <td>{{ 'Rp ' . number_format($payment->payment_amount, 2, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="font-extrabold {{ $payment->payment_status == 1 ? 'badge bg-light-success' : 'badge bg-light-warning' }}">{{ $payment->payment_status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="d-flex justify-content-start align-items-center">
                                            <a class="btn btn-sm btn-outline-danger" href="#"><i
                                                    class="icon dripicons dripicons-trash text-danger"></i></a>
                                            <a class="btn btn-sm btn-outline-warning mx-2" href="#"><i
                                                    class="icon dripicons dripicons-document-edit text-warning"></i></a>
                                            @if ($payment->payment_status == 1)
                                                <a class="btn btn-sm btn-outline-danger" href="#"><i
                                                        class="icon dripicons dripicons-wrong text-danger"></i></a>
                                            @elseif($payment->payment_status == 0)
                                                <a class="btn btn-sm btn-outline-success" href="#"><i
                                                        class="icon dripicons dripicons-checkmark text-success"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
