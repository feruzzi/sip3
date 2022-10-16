@extends('layouts.main.main')
@section('table_title', 'Ganti Password')
@section('content_title', 'Silahkan Ganti Password Anda')

@section('content')
    <section class="section">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="#">
                        @csrf
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" class="form-control round"
                                    placeholder="Password Baru">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    class="form-control round" placeholder="Konfirmasi Password Baru">
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="ms-auto btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
