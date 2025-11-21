<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Lelang Online</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .welcome-container {
            max-width: 1100px;
            width: 100%;
            padding: 20px;
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .welcome-header {
            background: white;
            padding: 50px 40px 30px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }

        .welcome-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .welcome-header p {
            font-size: 1.1rem;
            color: #6c757d;
        }

        .welcome-body {
            padding: 40px;
        }

        .feature-box {
            text-align: center;
            padding: 30px 20px;
            border-radius: 10px;
            background: #f8f9fa;
            height: 100%;
            transition: all 0.3s ease;
        }

        .feature-box:hover {
            background: #e9ecef;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
        }

        .feature-icon img {
            width: 100%;
            height: 100%;
            filter: invert(38%) sepia(89%) saturate(1280%) hue-rotate(201deg) brightness(93%) contrast(91%);
        }

        .feature-box h5 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .feature-box p {
            font-size: 0.95rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .login-section {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 10px;
            margin: 30px 0;
        }

        .login-section h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        .btn-login {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login-admin {
            background: #0d6efd;
            color: white;
            border: 2px solid #0d6efd;
        }

        .btn-login-admin:hover {
            background: #0b5ed7;
            border-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-login-user {
            background: white;
            color: #0d6efd;
            border: 2px solid #0d6efd;
        }

        .btn-login-user:hover {
            background: #0d6efd;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-icon {
            width: 24px;
            height: 24px;
        }

        .btn-login-admin .btn-icon img {
            filter: brightness(0) invert(1);
        }

        .btn-login-user .btn-icon img {
            filter: invert(38%) sepia(89%) saturate(1280%) hue-rotate(201deg) brightness(93%) contrast(91%);
        }

        .btn-login-user:hover .btn-icon img {
            filter: brightness(0) invert(1);
        }

        .register-section {
            text-align: center;
            padding: 30px 0;
            border-top: 1px solid #e9ecef;
        }

        .register-section p {
            color: #6c757d;
            margin-bottom: 15px;
        }

        .btn-register {
            padding: 10px 30px;
            font-size: 1rem;
            border-radius: 6px;
            border: 2px solid #6c757d;
            color: #6c757d;
            background: white;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        .footer-text {
            text-align: center;
            padding-top: 20px;
            color: #adb5bd;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <div class="welcome-card">
            {{-- Header --}}
            <div class="welcome-header">
                <h1>Sistem Lelang UKK</h1>
                {{-- <p>Platform lelang terpercaya dan transparan</p> --}}
            </div>

            {{-- Body --}}
            <div class="welcome-body">
                {{-- Features --}}
                {{-- <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <img src="{{ asset('assets/icons/shield-checkmark-outline.svg') }}" alt="Aman">
                            </div>
                            <h5>Aman & Terpercaya</h5>
                            <p>Sistem keamanan berlapis untuk melindungi data Anda</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <img src="{{ asset('assets/icons/flash-outline.svg') }}" alt="Cepat">
                            </div>
                            <h5>Proses Cepat</h5>
                            <p>Lelang real-time dengan notifikasi instan</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <img src="{{ asset('assets/icons/stats-chart-outline.svg') }}" alt="Transparan">
                            </div>
                            <h5>Transparan</h5>
                            <p>Semua proses lelang dapat dipantau dengan jelas</p>
                        </div>
                    </div>
                </div> --}}

                {{-- Login Section --}}
                <div class="login-section">
                    <h3 class="text-center">Silakan Pilih Portal Login</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.login') }}" class="btn btn-login btn-login-admin w-100">
                                <div class="btn-icon">
                                    <img src="{{ asset('assets/icons/shield-checkmark-outline.svg') }}" alt="Admin"
                                        style="width: 30px; height: auto;">
                                </div>

                                <span>Login Admin</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('masyarakat.login') }}" class="btn btn-login btn-login-user w-100">
                                <div class="btn-icon">
                                    <img src="{{ asset('assets/icons/person-outline.svg') }}" alt="Masyarakat"
                                        style="width: 30px; height: auto;">
                                </div>
                                <span>Login Masyarakat</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Register Section --}}
                <div class="register-section">
                    <p>Belum punya akun?</p>
                    <a href="{{ route('masyarakat.register') }}" class="btn btn-register">
                        Daftar Sekarang
                    </a>
                </div>

                {{-- Footer --}}
                <div class="footer-text">
                    &copy; {{ date('Y') }} Sistem Lelang Online. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
