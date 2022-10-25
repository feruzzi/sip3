@extends('layouts.main.main')
@push('header-js')
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endpush
@push('footer-js')
    <script src="{{ asset('assets/js/toast.js') }}"></script>
    <script>
        $(document).off('click', '.save-password').on('click', '.save-password', function() {
            $('.alert-light-danger').addClass('d-none');
            $.ajax({
                url: '{{ url('change-password') . '/' . auth()->user()->username }}',
                type: 'PUT',
                data: {
                    password: $('#password').val(),
                    confirm_password: $('#confirm_password').val(),
                },
                success: function(response) {
                    if (response.errors) {
                        console.log(response.errors)
                        $('.alert-light-danger').removeClass('d-none');
                        $('.alert-light-danger').html("<ul>");
                        $.each(response.errors, function(key, value) {
                            $('.alert-light-danger').find('ul').append("<li>" +
                                value +
                                "</li>");
                        });
                        $('.alert-light-danger').append("</ul>");
                        toastError(response.msg)
                    } else {
                        toastSuccess(response.msg)
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
@endpush
@section('table_title', 'Ganti Password')
@section('content_title', 'Silahkan Ganti Password Anda')

@section('content')
    <section class="section">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-light-danger color-danger d-none"></div>
                    {{-- <form action="{{ url('change-password') . '/' . auth()->user()->username }}" method="post"> --}}
                    {{-- @method('put') --}}
                    {{-- @csrf --}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control round"
                                placeholder="Password Baru">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="confirm_password">Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control round"
                                placeholder="Konfirmasi Password Baru">
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="ms-auto btn btn-primary save-password">Simpan</button>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
