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
            let tb_payment = $("#tb_detail_transaction").DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: "{{ url('detail-transaction/data') }}",
                dataSrc: '',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    }, {
                        data: 'username',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'payment_name',
                    },
                    {
                        data: 'pay',
                    },
                    {
                        data: 'pay_date',
                    },
                    {
                        data: 'note',
                    }, {
                        data: 'action'
                    }
                ],
            });
        });
        $(document).on("click", ".edit-transaction", function(e) {
            $(".bill-option").remove();
            $('#username').val("");
            $('#name').val("");
            $('#date').val("");
            $('#payment_id').val("");
            $('#pay').val("");
            $('#note').val("");
            var id = $(this).data('id');
            var transaction_id = $(this).data('transaction_id');
            var name = $(this).data('name');
            $.ajax({
                url: "bill/detail/" + id,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $('#username').val(id)
                    $('#name').val(name)
                    $('#transaction_id').val(transaction_id)
                    $.each(response, function(key, value) {
                        $(".bill-list").append("<option class='bill-option' value='" + value
                            .bill_id + "'>" + value
                            .payment_name + "</option>"
                        );
                    });
                    $.ajax({
                        url: 'detail-transaction/' + transaction_id + '/edit',
                        type: 'GET',
                        success: function(response) {
                            console.log(response.result);
                            $('#edit-transaction-modal').modal('show');
                            $('.alert-light-danger').addClass('d-none');
                            $('#date').val(response.result.pay_date);
                            $('#pay').val(response.result.pay);
                            $('#note').val(response.result.note);
                            $('#payment_id').val(response.result.bill_id);
                            $(document).off('click', '.save-pay').on('click', '.save-pay',
                                function() {
                                    $.ajax({
                                        url: "detail-transaction/" +
                                            transaction_id,
                                        type: "PUT",
                                        data: {
                                            date: $('#date').val(),
                                            transaction_id: $('#transaction_id')
                                                .val(),
                                            pay: $('#pay').autoNumeric('get'),
                                            note: $('#note').val(),
                                            bill_id: $('#payment_id').val(),
                                        },
                                        success: function(response) {
                                            if (response.errors) {
                                                $('.alert-light-danger')
                                                    .removeClass('d-none');
                                                $('.alert-light-danger')
                                                    .html("<ul>");
                                                $.each(response.errors,
                                                    function(key,
                                                        value) {
                                                        $('.alert-light-danger')
                                                            .find('ul')
                                                            .append(
                                                                "<li>" +
                                                                value +
                                                                "</li>"
                                                            );
                                                    });
                                                $('.alert-light-danger')
                                                    .append("</ul>");
                                                toastError(response.msg)
                                            } else {
                                                console.log(response);
                                                $('.alert-light-danger')
                                                    .addClass('d-none');
                                                $("#tb_detail_transaction")
                                                    .DataTable().ajax
                                                    .reload();
                                                $('#edit-transaction-modal')
                                                    .modal(
                                                        'hide');
                                                toastSuccess(response.msg)
                                            }
                                        }
                                    });
                                });
                        }
                    });
                }
            });
        });
        // delete
        $(document).on("click", ".delete-transaction", function(e) {
            var id = $(this).data('transaction_id');
            $('#modal-delete').modal('show');
            $(document).off('click', '.delete-data').on('click', '.delete-data', function() {
                console.log(id)
                $.ajax({
                    url: 'detail-transaction/delete/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        $("#tb_detail_transaction").DataTable().ajax.reload(null, false);
                        $('#modal-delete').modal('hide');
                        toastSuccess(response.msg)
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
@endpush
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Transaksi</h3>
                <p class="text-subtitle text-muted">Informasi Detail Transaksi</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('detail-transaction') }}">Detail Transaksi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="col-12">
            {{-- <div class="d-flex mb-3">
                <a class="ms-auto btn btn-primary">Tambah Transaksi Baru</a>
            </div> --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Transaksi</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tb_detail_transaction">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Pembayaran</th>
                                    <th>Bayar</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade text-left" id="edit-transaction-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title white" id="myModalLabel160">Edit Transaksi
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light-danger color-danger d-none"></div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control round"
                            placeholder="Username" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" class="form-control round" placeholder="Nama"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label for="transaction_id">ID Transaksi</label>
                        <input type="text" id="transaction_id" name="transaction_id" class="form-control round"
                            placeholder="ID Transaksi" disabled>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal Pembayaran</label>
                        <input type="date" id="date" name="date" class="form-control round"
                            placeholder="Tanggal Pembayaran">
                    </div>
                    <div class="form-group">
                        <label for="payment_id">Pembayaran</label>
                        <select id="payment_id" name="payment_id" class="form-select bill-list">
                            {{-- !! Isi payment list --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pay">Jumlah Dibayar</label>
                        <input type="text" id="pay" name="pay" class="form-control round amount_format"
                            placeholder="Jumlah Dibayar">
                    </div>
                    <div class="form-group">
                        <label for="note">Keterangan</label>
                        <textarea class="form-control" name="note" id="note" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 save-pay">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.components.delete-modal')
@endsection
