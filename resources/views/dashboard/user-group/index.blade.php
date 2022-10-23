@extends('layouts.dashboard.dashboard')
@push('header-js')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endpush
@push('footer-js')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('assets/js/toast.js') }}"></script>
    <script src="{{ asset('assets/js/currency_converter.js') }}"></script>
    <script>
        $(document).ready(function() {
            let tb_group1 = $("#tb_group1").DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: "{{ url('group1/data') }}",
                dataSrc: '',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'group1_id',
                    },
                    {
                        data: 'group1_name',
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action',
                    }
                ],
            });
        });
        $(document).ready(function() {
            let tb_group2 = $("#tb_group2").DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: "{{ url('group2/data') }}",
                dataSrc: '',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'group2_id',
                    },
                    {
                        data: 'group2_name',
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action',
                    }
                ],
            });
        });
    </script>
    @include('dashboard.user-group.group1.index')
    @include('dashboard.user-group.group2.index')
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
@endpush
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Pengelompokan User</h3>
                <p class="text-subtitle text-muted">Informasi Pengaturan User</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('users/user-group') }}">Users Group</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="col-12">
            <div class="d-flex mb-3">
                <a class="ms-auto btn btn-primary add-group1">Tambah Kelompok Angkatan Baru</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Angkatan</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tb_group1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Angkatan</th>
                                    <th>Angkatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="col-12">
            <div class="d-flex mb-3">
                <a class="ms-auto btn btn-primary add-group2">Tambah Kelompok Jurusan Baru</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Jurusan</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tb_group2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Jurusan</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('dashboard.user-group.group1.group1-modal')
    @include('dashboard.user-group.group2.group2-modal')
    @include('layouts.components.delete-modal')
@endsection
