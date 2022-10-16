@extends('layouts.dashboard.dashboard')
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
                <a class="ms-auto btn btn-primary">Tambah User Baru</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Users</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive m-3">
                        <table class="table table-hover table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Angkatan</th>
                                    <th>Jurusan</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->group1 }}</td>
                                        <td>{{ $user->group2 }}</td>
                                        <td>
                                            <span
                                                class="font-extrabold mx-3 {{ $user->level == 1 ? 'badge bg-light-danger' : 'badge bg-light-secondary' }}">{{ $user->level == 1 ? 'Administator' : 'Pengguna' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="font-extrabold {{ $user->status == 1 ? 'badge bg-light-success' : 'badge bg-light-warning' }}">{{ $user->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="d-flex justify-content-start align-items-center">
                                            <a class="btn btn-sm btn-outline-danger" href="#"><i
                                                    class="icon dripicons dripicons-trash text-danger"></i></a>
                                            <a class="btn btn-sm btn-outline-warning mx-2" href="#"><i
                                                    class="icon dripicons dripicons-document-edit text-warning"></i></a>
                                            @if ($user->status == 1)
                                                <a class="btn btn-sm btn-outline-danger" href="#"><i
                                                        class="icon dripicons dripicons-wrong text-danger"></i></a>
                                            @elseif($user->status == 0)
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
