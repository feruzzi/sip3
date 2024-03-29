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
            let tb_bill = $("#tb_user").DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ url('users/data') }}",
                dataSrc: '',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'group1'
                    },
                    {
                        data: 'group2',
                    },
                    {
                        data: 'level',
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
        $(document).on('click', ".add-user", function(e) {
            $('.alert-light-danger').addClass('d-none');
            $(".modal-header").addClass("bg-primary")
            $(".modal-header").removeClass("bg-warning")
            $("#username").prop('disabled', false);
            $('.modal-header #user-modal-header').text('Tambah User');
            $("#username").val("");
            $("#name").val("");
            $("#password").val("");
            $('#add-user-modal').modal('show');
            $(document).off('click', '.save-user').on('click', '.save-user', function() {
                createUpdate();
            });
        });
        $(document).on('click', ".edit-user", function(e) {
            $('.alert-light-danger').addClass('d-none');
            var id = $(this).data('id');
            $("#username").val("");
            $("#username").prop('disabled', true);
            $("#name").val("");
            $("#password").val("");
            $('#add-user-modal').modal('show');
            $.ajax({
                url: 'user/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $(".modal-header").removeClass("bg-primary")
                    $(".modal-header").addClass("bg-warning")
                    $('.modal-header #user-modal-header').text('Edit User');
                    $('#username').val(response.result.username);
                    $('#name').val(response.result.name);
                    $('#group1').val(response.result.group1);
                    $('#group2').val(response.result.group2);
                    $('#level').val(response.result.level);
                    $(document).off('click', '.save-user').on('click', '.save-user', function() {
                        createUpdate(id);
                    });
                }
            });
        });

        function createUpdate(id = '') {
            if (id == '') {
                var type_ = "POST";
                var url_ = 'user/add';
            } else {
                var type_ = "PUT";
                var url_ = 'user/' + id;
            }
            $.ajax({
                url: url_,
                type: type_,
                data: {
                    username: $('#username').val(),
                    name: $('#name').val(),
                    password: $('#password').val(),
                    group1: $('#group1').val(),
                    group2: $('#group2').val(),
                    level: $('#level').val(),
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
                        $('#add-user-modal').modal('hide');
                        $("#tb_user").DataTable().ajax.reload();
                        toastSuccess(response.msg)
                    }
                }
            });
        }
        $(document).on('click', ".set-user", function(e) {
            var id = $(this).data('id');
            $.ajax({
                url: 'user/set/' + id,
                type: "PUT",
                success: function(response) {
                    $("#tb_user").DataTable().ajax.reload(null, false);
                    toastSuccess(response.msg)
                }
            });
        });
        $(document).on('click', ".delete-user", function(e) {
            var id = $(this).data('id');
            $('#modal-delete').modal('show');
            $('.delete-message').text('Data Username ' + id + ' akan hilang dari database. Yakin Hapus ?');
            $(document).off('click', '.delete-data').on('click', '.delete-data', function() {
                $.ajax({
                    url: 'user/delete/' + id,
                    type: "DELETE",
                    success: function(response) {
                        if (response.errors) {
                            toastError(response.errors)
                        } else {
                            $('#modal-delete').modal('hide');
                            $("#tb_user").DataTable().ajax.reload(null, false);
                            toastSuccess(response.msg)
                        }
                    }
                });
            });
        });
        $(document).on('click', ".import-user", function(e) {
            $('#file').val("")
            $('#import-user-modal').modal('show');
            $(document).off('click', '.save-import-user').on('click', '.save-import-user', function() {
                $(" #user-upload-status span").text("Mohon Tunggu . . .");
                var fd = new FormData($("#form-import-user")[0]);
                $.ajax({
                    url: 'user/import',
                    type: "POST",
                    data: fd,
                    xhr: function() {
                        //upload Progress
                        var xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            xhr.upload.addEventListener('progress', function(event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = Math.ceil(position / total * 100);
                                }
                                //update progressbar
                                $(" .user-upload-bar").css("width", +
                                    percent + "%");
                                $(" .status").text(percent + "%");
                                if (percent == 100) {
                                    $(" #user-upload-status span").text(
                                        "Upload Sukses !!!");
                                    $(" #user-upload-status span").removeClass(
                                        "bg-light-danger");
                                    $(" #user-upload-status span").addClass(
                                        "bg-light-success");
                                }
                            }, true);
                        }
                        return xhr;
                    },
                    success: function(response) {
                        $('#import-user-modal').modal('hide');
                        $("#tb_user").DataTable().ajax.reload(null, false);
                        toastSuccess(response.msg)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
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
                <h3>Users</h3>
                <p class="text-subtitle text-muted">Informasi User</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('users') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="col-12">
            <div class="d-flex mb-3">
                <div class="ms-auto">
                    <a class="btn btn-success import-user mx-3">Import User Excel</a>
                    <a class="btn btn-primary add-user">Tambah User Baru</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Users</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0" id="tb_user">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Angkatan</th>
                                    <th>Jurusan</th>
                                    <th>Level</th>
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
    <div class="modal fade text-left" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="user-modal-header">Tambah User
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light-danger color-danger d-none"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control round"
                                    placeholder="Username">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" id="name" name="name" class="form-control round"
                                    placeholder="Nama">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control round"
                                    placeholder="Password">
                            </div>
                        </div>
                    </div>
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
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="level">Jurusan</label>
                                <select id="level" name="level" class="form-select">
                                    <option value="0">Siswa</option>
                                    <option value="1">Administator</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 save-user">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="import-user-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel110" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title white" id="myModalLabel110">Import User
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <a href="{{ asset('template_upload_users.xlsx') }}" class="ms-auto btn btn-success">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Download Tempate Excel</span>
                        </a>
                    </div>
                    <form id="form-import-user" name="form-import-user" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File EXCEL</label>
                            <input class="form-control form-control-sm" id="file" name="file" type="file">
                            <code>ID Angkatan dan ID Jurusan yang diupload harus sudah terdaftar terlebih dahulu </code>
                            <div class="progress progress-success progress-sm  mb-4">
                                <div class="progress-bar user-upload-bar" role="progressbar" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                            <p id="user-upload-status">
                                <span class="font-extrabold badge bg-light-danger"></span>
                            </p>
                        </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </a>

                    <button type="button" class="btn btn-success ml-1 save-import-user">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload</span>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.components.delete-modal')
@endsection
