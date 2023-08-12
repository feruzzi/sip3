@extends('layouts.dashboard.dashboard')
@push('header-js')
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endpush
@push('footer-js')
    <script src="{{ asset('assets/js/toast.js') }}"></script>
    <script>
        $(document).off('change', '#select_all_users').on('change', '#select_all_users', function() {
            if (this.checked) {
                $(".user-checkbox").prop('checked', true);
            } else {
                $(".user-checkbox").prop('checked', false);
            }
        })
        $(document).off('click', '.confirm-modal').on('click', '.confirm-modal', function() {
            var selectedUsers = [];
            $(".user-checkbox:checked").each(function() {
                selectedUsers.push($(this).val());
            });
            if (selectedUsers.length == 0) {
                toastError("Pilih User Terlebih Dahulu")
            } else {
                $("#selected-counts").text(selectedUsers.length)
                $("#confirm-modal").modal('show')
            }
        })
        $(document).off('click', '.process-user').on('click', '.process-user', function() {
            $("#select_all_users").prop('checked', false);
            var selectedUsers = [];
            $(".user-checkbox:checked").each(function() {
                selectedUsers.push($(this).val());
            });
            $(".list-users").remove();
            $.ajax({
                url: "user/edit/groups",
                type: "PUT",
                data: {
                    users: selectedUsers,
                    group1: $('#to-group1').val(),
                    group2: $('#to-group2').val(),
                },
                success: function(response) {
                    console.log(response)
                    toastSuccess(response.msg)
                }
            });
        })
        $(document).off('click', '.filter-user').on('click', '.filter-user', function() {
            $("#select_all_users").prop('checked', false);
            $(".list-users").remove();
            $.ajax({
                url: "user/filter",
                type: "POST",
                data: {
                    group1: $('#find-group1').val(),
                    group2: $('#find-group2').val(),
                },
                success: function(response) {
                    console.log(response)
                    toastSuccess(response.msg)
                    $.each(response.res, function(key, value) {
                        $(".list-filter-user").append(`<div class="col-sm-6 col-md-3 list-users">
                                    <ul class="list-group">
                                        <li class="list-group-item my-1 text-truncate" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="` + value.name + `">
                                            <div class="d-flex align-items-center">
                                                <input class="form-check-input me-1 user-checkbox" type="checkbox"
                                                    value="` + value.username + `" aria-label="...">
                                                <div class="ms-3">
                                                    <label class="d-block fw-bolder">` + value.username + `</label>
                                                    <label class="d-block">` + value.name + `</label>
                                                    <label class="d-block">` + value.group1_name + `/` + value
                            .group2_name + `</label>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>`)
                        $("#init-group1").val(value.group1_name)
                        $("#init-group2").val(value.group2_name)
                    })
                    if ($('#find-group1').val() == "") {
                        $("#init-group1").val("Semua")
                    }
                    if ($('#find-group2').val() == "") {
                        $("#init-group2").val("Semua")
                    }
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
                <h3>Kelola Kelompok User</h3>
                <p class="text-subtitle text-muted">Kelompok User</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('manage-user-group') }}">Kelola Kelompok User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Users</h4>
                </div>
                <div class="card-content">
                    <div class="d-flex m-3">
                        <div class="me-auto">
                            <div class="form-group d-flex g-3 align-items-end">
                                <div class="form-group">
                                    <label for="find-group1">Pilih Kelas</label>
                                    <select class="form-control" name="find-group1" id="find-group1">
                                        <option value="">Semua</option>
                                        @foreach ($groups1 as $group1)
                                            <option value="{{ $group1->group1_id }}">{{ $group1->group1_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mx-3">
                                    <label for="find-group2">Pilih Jurusan</label>
                                    <select class="form-control" name="find-group2" id="find-group2">
                                        <option value="">Semua</option>
                                        @foreach ($groups2 as $group2)
                                            <option value="{{ $group2->group2_id }}">{{ $group2->group2_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary filter-user">Cari</button>
                                    {{-- <button type="button" class="btn btn-primary process-user">Submit</button> --}}
                                    <button type="button" class="btn btn-primary confirm-modal">
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-3">
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" class="form-check-input" id="select_all_users">
                                <label for="select_all_users">Pilih Semua</label>
                            </div>
                        </div>
                        <div class="row list-filter-user">
                            {{-- @foreach ($users as $user)
                                <div class="col-sm-6 col-md-3">
                                    <ul class="list-group">
                                        <li class="list-group-item my-1 text-truncate" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="{{ $user->name }}">
                                            <div class="d-flex align-items-center">
                                                <input class="form-check-input me-1" type="checkbox"
                                                    value="{{ $user->username }}" aria-label="...">
                                                <div class="ms-3">
                                                    <label class="d-block fw-bolder">{{ $user->username }}</label>
                                                    <label class="d-block">{{ $user->name }}</label>
                                                    <label class="d-block">{{ $user->group1 }}/{{ $user->group2 }}</label>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade text-left" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Kelola Kelas/Rombel</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <div class="d-flex">
                            <div class="d-block">
                                <label class="text-truncate">Kelas Saat Ini</label>
                                <input type="text" class="form-control" id="init-group1" disabled>
                            </div>
                            <div class="d-block mx-2">
                                <label class="text-truncate">Jurusan Saat Ini</label>
                                <input type="text" class="form-control" id="init-group2" disabled>
                            </div>
                        </div>
                        <h3 class="mt-3">→</h3>
                        <div class="d-flex w-100 mt-3">
                            <div class="form-group w-100 mx-2">
                                <label class="text-truncate">Kelas Baru</label>
                                <select class="form-control" name="to-group1" id="to-group1">
                                    @foreach ($groups1 as $group1)
                                        <option value="{{ $group1->group1_id }}">{{ $group1->group1_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label class="text-truncate">Jurusan Baru</label>
                                <select class="form-control" name="to-group2" id="to-group2">
                                    @foreach ($groups2 as $group2)
                                        <option value="{{ $group2->group2_id }}">{{ $group2->group2_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="fst-italic text-capitalize">Sebanyak <span id="selected-counts"></span> User telah dipilih dan
                        akan berubah
                        seluruhnya</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 process-user" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Submit</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
