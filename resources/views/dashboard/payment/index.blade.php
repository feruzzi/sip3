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
            let tb_payment = $("#tb_payment").DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ url('payment/data') }}",
                dataSrc: '',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'payment_id',
                    },
                    {
                        data: 'payment_name',
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'action',
                    }
                ],
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".add-payment", function(e) {
                $('#payment-modal').modal('show');
                $("#payment_id").prop('disabled', false);
                $('.alert-light-danger').addClass('d-none');
                $('#payment_id').val("");
                $('#payment_name').val("");
                $('#payment_amount').val("");
                $(document).off('click', '.save-payment').on('click', '.save-payment', function() {
                    createUpdate();
                });
            });
            $(document).on("click", ".delete-payment", function(e) {
                var id = $(this).data('id');
                $('#modal-delete').modal('show');
                $(document).off('click', '.delete-data').on('click', '.delete-data', function() {
                    $.ajax({
                        url: 'payment/delete/' + id,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.errors) {
                                toastError(response.errors)
                            } else {
                                $("#tb_payment").DataTable().ajax.reload(null, false);
                                $('#modal-delete').modal('hide');
                                toastSuccess(response.msg)
                            }
                        }
                    });
                });
            });
            $(document).on('click', ".edit-payment", function(e) {
                var id = $(this).data('id');
                $("#payment_id").prop('disabled', true);
                $('.alert-light-danger').addClass('d-none');
                $('#payment_id').val("");
                $('#payment_name').val("");
                $('#payment_amount').val("");
                $.ajax({
                    url: 'payment/' + id + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('.modal-header #modal-payment-title').text('Edit Pembayaran');
                        $('#payment-modal').modal('show');
                        $('#payment_id').val(response.result.payment_id);
                        $('#payment_name').val(response.result.payment_name);
                        $('#payment_amount').val(response.result.payment_amount);
                        $(document).off('click', '.save-payment').on('click', '.save-payment',
                            function() {
                                createUpdate(id);
                            });
                    }
                });
            });
            $(document).on('click', ".set-payment", function(e) {
                var id = $(this).data('id');
                $.ajax({
                    url: 'payment/set/' + id,
                    type: "PUT",
                    data: {
                        payment_id: $('#payment_id').val()
                    },
                    success: function(response) {
                        $("#tb_payment").DataTable().ajax.reload(null, false);
                        toastSuccess(response.msg)
                    }
                });
            });
        });
    </script>
    <script>
        function createUpdate(id = '') {
            if (id == '') {
                var type_ = "POST";
                var url_ = 'payment/add';
            } else {
                var type_ = "PUT";
                var url_ = 'payment/' + id;
            }
            $.ajax({
                url: url_,
                type: type_,
                data: {
                    payment_id: $('#payment_id').val(),
                    payment_name: $('#payment_name').val(),
                    payment_amount: $('#payment_amount').autoNumeric('get')
                },
                success: function(response) {
                    if (response.errors) {
                        $('.alert-light-danger').removeClass('d-none');
                        $('.alert-light-danger').html("<ul>");
                        $.each(response.errors, function(key, value) {
                            $('.alert-light-danger').find('ul').append("<li>" + value +
                                "</li>");
                        });
                        $('.alert-light-danger').append("</ul>");
                        toastError(response.msg)
                    } else {
                        $("#tb_payment").DataTable().ajax.reload();
                        $('#payment-modal').modal('hide');
                        toastSuccess(response.msg)
                    }
                }
            });
        }
    </script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
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
                <a class="ms-auto btn btn-primary add-payment">Tambah
                    Pembayaran Baru</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Pembayaran</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tb_payment">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade text-left modal-borderless" id="payment-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-payment-title">Tambah Pembayaran</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light-danger color-danger d-none"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="payment_id">ID Pembayaran</label>
                            <input type="text" id="payment_id" name="payment_id" class="form-control round"
                                placeholder="ID Pembayaran">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="payment_name">Nama Pembayaran</label>
                            <input type="text" id="payment_name" name="payment_name" class="form-control round"
                                placeholder="Nama Pembayaran">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="payment_amount">Nominal Pembayaran</label>
                            <input type="text" id="payment_amount" name="payment_amount"
                                class="form-control round amount_format" placeholder="Nominal Pembayaran">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 save-payment">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.components.delete-modal')
@endsection
