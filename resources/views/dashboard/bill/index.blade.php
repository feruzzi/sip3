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
                <h3>Tagihan</h3>
                <p class="text-subtitle text-muted">Informasi Data Tagihan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('bill') }}">Tagihan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="col-12">
            <div class="d-flex mb-3">
                <a class="ms-auto btn btn-primary">Tambah Tagihan Baru</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Tagihan</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tagihan</th>
                                    <th>Total Tagihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bill->name }}</td>
                                        <td>{{ $bill->tagihan . ' Tagihan' }}</td>
                                        <td>
                                            <span
                                                class="font-extrabold badge bg-light-danger">{{ 'Rp ' . number_format($bill->total_bill, 2, ',', '.') }}</span>
                                        </td>
                                        <td class="d-flex justify-content-start align-items-center">
                                            <a class="btn btn-sm btn-outline-primary" href="#"><i
                                                    class="icon dripicons dripicons-plus text-primary"></i></a>
                                            <a class="btn btn-sm btn-outline-danger mx-2" href="#"><i
                                                    class="icon dripicons dripicons-trash text-danger"></i></a>
                                            <a class="btn btn-sm btn-outline-warning me-2" href="#"><i
                                                    class="icon dripicons dripicons-document-edit text-warning"></i></a>
                                            <a class="btn btn-sm btn-outline-info" href="#"><i
                                                    class="icon dripicons dripicons-information text-info"></i></a>
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
