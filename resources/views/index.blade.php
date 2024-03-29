<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIP</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/Syntax_Error.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/Syntax_Error.png') }}" type="image/png">
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="{{ asset('assets/images/logo/Syntax_Error.svg') }}"
                                alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Silahkan Login Kedalam <b>Sistem Informasi Pembayaran</b> menggunakan
                        <b>Username</b> dan <b>Password ANDA</b>
                    </p>
                    @if (session('loginError'))
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">Login Gagal</h4>
                            <p>{{ session('loginError') }}</p>
                        </div>
                    @endif
                    <form action="{{ url('auth/login') }}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" id="username" name="username" class="form-control form-control-xl"
                                placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password" name="password" class="form-control form-control-xl"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <section class="text-center d-flex flex-column vh-100">
                        <div class="my-auto">
                            <h1 style="color:rgb(226, 226, 226)">SIP</h1>
                            <h2 style="color:rgb(226, 226, 226)">Sistem Informasi Pembayaran</h2>
                            <h3 style="color:rgb(226, 226, 226)">Pantau Tagihan dan Riwayat Pembayaran Dimana Saja dan
                                Kapan
                                Saja</h3>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
