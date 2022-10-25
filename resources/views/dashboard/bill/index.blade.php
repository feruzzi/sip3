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
            let tb_bill = $("#tb_bill").DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: "{{ url('bill/data') }}",
                dataSrc: '',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'tagihan',
                    },
                    {
                        data: 'total_bill'
                    },
                    {
                        data: 'action',
                    }
                ],
            });
        });
        $(document).on("click", ".add-mass-bill", function(e) {
            $('#mass-bill-modal').modal('show');
            $(document).off('click', '.save-mass-bill').on('click', '.save-mass-bill', function() {
                $.ajax({
                    url: "bill/mass_add",
                    type: "POST",
                    data: {
                        group1: $('#group1').val(),
                        group2: $('#group2').val(),
                        payment_id: $('#payment_id').val()
                    },
                    success: function(response) {
                        // console.log(response);
                        $("#tb_bill").DataTable().ajax.reload();
                        $('#mass-bill-modal').modal('hide');
                        toastSuccess(response.msg)

                    }
                });
            });
        });
        $(document).on("click", ".add-bill", function(e) {
            var id = $(this).data('id');
            alert(id);
            $.ajax({
                url: "bill/show/" + id,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $('#add-bill-modal').modal('show');
                    $('#username').val(response.username);
                    $('#name').val(response.name);
                    $(document).off('click', '.save-bill').on('click', '.save-bill',
                        function() {
                            $.ajax({
                                url: "bill/add",
                                type: "POST",
                                data: {
                                    username: $('#username').val(),
                                    payment_id: $('#payment_id_2').val(),
                                    bill_amount: $('#bill_amount').autoNumeric('get'),
                                },
                                success: function(response) {
                                    if (response.errors) {
                                        $('.alert-light-danger').removeClass('d-none');
                                        $('.alert-light-danger').html("<ul>");
                                        $.each(response.errors, function(key, value) {
                                            $('.alert-light-danger').find('ul')
                                                .append("<li>" + value +
                                                    "</li>");
                                        });
                                        $('.alert-light-danger').append("</ul>");
                                        toastError(response.msg)
                                    } else {
                                        console.log(response);
                                        $('.alert-light-danger').addClass('d-none');
                                        $("#tb_bill").DataTable().ajax.reload();
                                        $('#add-bill-modal').modal('hide');
                                        toastSuccess(response.msg)
                                    }
                                }
                            });
                        });
                }
            });
        });
        $(document).on("click", ".delete-bill", function(e) {
            $(".list-bill").remove();
            $('#delete-bill-modal').modal('show');
            var id = $(this).data('id');
            alert(id);
            $.ajax({
                url: "bill/detail/" + id,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $.each(response, function(key, value) {
                        $(".body_list_bill").append("<tr class='list-bill'><td>" +
                            value.bill_id + "</td><td>" +
                            value.payment_name + "</td><td>Rp " + toRupiah(value
                                .bill_amount) +
                            "</td><td><div class='form-check'><div class='custom-control custom-checkbox'><input type='checkbox' class='bill_id form-check-input form-check-danger form-check-glow' value='" +
                            value.bill_id + "' name='bill_id[]'></div></div></td></tr>"
                        );
                    });
                    $(document).off('click', '.destroy-bill').on('click', '.destroy-bill', function() {
                        var bill_ids = [];
                        $('.bill_id:checked').each(function(i) {
                            bill_ids[i] = $(this).val();
                        });
                        $.ajax({
                            url: "bill/delete",
                            type: "POST",
                            data: {
                                bill_id: bill_ids,
                            },
                            success: function(response) {
                                if (response.errors) {
                                    toastError(response.errors)
                                } else {
                                    console.log(response);
                                    $("#tb_bill").DataTable().ajax.reload();
                                    $('#delete-bill-modal').modal('hide');
                                    toastSuccess(response.msg)
                                }
                            }
                        });
                    });
                }
            });
        });
        $(document).on("click", ".edit-bill", function(e) {
            $(".list-bill").remove();
            $('#edit-bill-modal').modal('show');
            var id = $(this).data('id');
            alert(id);
            $.ajax({
                url: "bill/detail/" + id,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $.each(response, function(key, value) {
                        $(".list-edit-bill").append(
                            "<div class='form-group list-bill'><label for='" +
                            value.bill_id + "'>" + value.payment_name +
                            "</label><input type='text' data-bill='" + value.bill_id +
                            "' name='bill_amount_2' id='bill_amount_2' class='form-control round amount_format' placeholder='Nominal Pembayaran' value='" +
                            value.bill_amount + "'></div>"
                        );
                    });
                    $('.amount_format').autoNumeric('init', {
                        aSep: ".",
                        aDec: ",",
                        mDec: "0",
                    });
                    $(document).off('click', '.update-bill').on('click', '.update-bill', function() {
                        // var bill_id = $("#bill_amount_2").serialize();
                        var data_bill = [];
                        $('input[name="bill_amount_2"]').each(function() {
                            data_bill.push({
                                bill_id: $(this).data('bill'),
                                bill_amount: $(this).autoNumeric('get'),
                            });
                        });
                        $.ajax({
                            url: "bill/update/" + id,
                            type: "PUT",
                            data: {
                                data_bill: data_bill,
                            },
                            success: function(response) {
                                console.log(response);
                                $("#tb_bill").DataTable().ajax.reload();
                                $('#edit-bill-modal').modal('hide');
                                toastSuccess(response.msg)
                            }
                        });
                    })
                }
            });
        });
        $(document).on("click", ".detail-bill", function(e) {
            $(".list-bill").remove();
            $('#detail-bill-modal').modal('show');
            var id = $(this).data('id');
            alert(id);
            $.ajax({
                url: "bill/detail/" + id,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    // $('.body_detail_bill').html("<tbody>");
                    // $('.body_detail_bill').html("<tr>");
                    $.each(response, function(key, value) {
                        $(".body_detail_bill").append("<tr class='list-bill'><td>" +
                            value.payment_name + "</td><td>Rp " + toRupiah(value
                                .bill_amount) +
                            "</td></tr>");
                        // $('.body_detail_bill').find('tbody').append("<td>" + value
                        //     .payment_name +
                        //     "</td>");
                        // $('.body_detail_bill').find('tbody').append("<td>" + value
                        //     .bill_amount +
                        //     "</td>");
                    });

                    // $('.body_detail_bill').append("</tr>");
                    // $('.body_detail_bill').append("</tbody>");
                }
            });
        });
    </script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
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
                <a class="ms-auto btn btn-primary add-mass-bill">Tambah Tagihan Baru</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Tagihan</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tb_bill">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tagihan</th>
                                    <th>Total Tagihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
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
                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade text-left modal-borderless" id="mass-bill-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-mass-bill-title">Tambah Tagihan Berkelompok</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light-danger color-danger d-none"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="group1">Tahun</label>
                                <select id="group1" name="group1" class="form-select">
                                    @foreach ($groups1 as $group1)
                                        <option value="{{ $group1->group1_id }}">{{ $group1->group1_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="group2">Jurusan</label>
                                <select id="group2" name="group2" class="form-select">
                                    @foreach ($groups2 as $group2)
                                        <option value="{{ $group2->group2_id }}">{{ $group2->group2_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="payment_id">Pembayaran</label>
                                <select id="payment_id" name="payment_id" class="form-select">
                                    @foreach ($payments as $payment)
                                        <option value="{{ $payment->payment_id }}">{{ $payment->payment_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 save-mass-bill">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="detail-bill-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="myModalLabel130">Detail Tagihan
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-borderless mb-0" id="tb_detail_bill">
                            <thead>
                                <tr>
                                    <th>Tagihan</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="body_detail_bill">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button> --}}
                    <button type="button" class="btn btn-info ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">OK</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="add-bill-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Tambah Tagihan
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light-danger color-danger d-none"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control round"
                                placeholder="Username" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" class="form-control round"
                                placeholder="Nama" disabled>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="payment_id_2">Pembayaran</label>
                                <select id="payment_id_2" name="payment_id_2" class="form-select">
                                    @foreach ($payments as $payment)
                                        <option value="{{ $payment->payment_id }}">{{ $payment->payment_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bill_amount">Nominal Pembayaran</label>
                            <input type="text" id="bill_amount" name="bill_amount"
                                class="form-control round amount_format" placeholder="Nominal Pembayaran">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 save-bill">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="delete-bill-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Hapus Tagihan
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Centang Pada Pembayaran yang ingin dihapus
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-borderless mb-0" id="tb_list_bill">
                            <thead>
                                <tr>
                                    <th>ID Tagihan</th>
                                    <th>Tagihan</th>
                                    <th>Nominal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="body_list_bill">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-danger ml-1 destroy-bill">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="edit-bill-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel140" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title white" id="myModalLabel140">Edit Tagihan
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-edit-bill">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>

                    <button type="button" class="btn btn-warning ml-1 update-bill">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
