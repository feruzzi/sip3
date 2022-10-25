<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIP - Sistem Informasi Pembayaran</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
    @stack('header-js')

</head>

<body>
    <div id="app">
        <header class='mb-3'>
            <nav class="navbar navbar-expand navbar-light navbar-top">
                <div class="container-fluid">
                    <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                            height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                    opacity=".3"></path>
                                <g transform="translate(-210 -1)">
                                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                    <circle cx="220.5" cy="11.5" r="4"></circle>
                                    <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <div class="form-check form-switch fs-6">
                            <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                            <label class="form-check-label"></label>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                            preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                            </path>
                        </svg>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-menu d-flex">
                                    <div class="user-name text-end me-3">
                                        <h6 class="mb-0 text-gray-600">{{ $name }}</h6>
                                        <p class="mb-0 text-sm text-gray-600">{{ auth()->user()->username }}</p>
                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img src="{{ asset('assets/images/faces/1.jpg') }}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                style="min-width: 11rem;">
                                <li>
                                    <h6 class="dropdown-header">Hello, {{ $name }}!</h6>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('change-password') }}"><i
                                            class="icon-mid bi bi-person me-2"></i>
                                        Ganti Password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="{{ url('auth/logout') }}"><i
                                            class="icon-mid bi bi-box-arrow-left me-2 text-danger"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <hr>
        <div class="mx-5">
            <div class="page-heading">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <a href="{{ url('info/bill') }}"
                        class="btn btn-outline-primary mx-2 {{ $set_active == 'bill' ? 'active' : '' }}">Tagihan</a>
                    <a href="{{ url('info/transaction') }}"
                        class="btn btn-outline-primary {{ $set_active == 'transaction' ? 'active' : '' }}">Riwayat</a>
                </div>
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>@yield('table_title')</h3>
                            <p class="text-subtitle text-muted">@yield('content_title')</p>
                        </div>
                    </div>
                </div>
                @yield('content')
                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2022 &copy; Syntax Error Teams</p>
                        </div>
                        <div class="float-end">
                            <p>With <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                    href="https://github.com/feruzzi">FRZ</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('footer-js')

</body>

</html>
