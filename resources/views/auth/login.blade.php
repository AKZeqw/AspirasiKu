@extends('layouts.app')

@section('title', 'Login - AspirasiKu')

@push('styles')
<style>
    body {
        background-color: #e8ecf3;
        font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }
    .login-header h3 { font-weight: 600; color: #2B2D42; }
    .login-header p { color: #8D99AE; font-size: 0.9rem; }
    .form-control {
        background-color: #f8f9fa;
        border: 2px solid #eee;
        border-radius: 12px;
        padding: 12px 15px;
        transition: all 0.3s;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #4361EE;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }
    /* Style untuk toggle password */
    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .input-group .btn-toggle-password {
        border: 2px solid #eee;
        border-left: none;
        background-color: #f8f9fa;
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
        color: #6c757d;
        z-index: 4;
    }
    .input-group .btn-toggle-password:hover {
        background-color: #e9ecef;
        color: #4361EE;
    }
    .btn-primary {
        background-color: #4361EE;
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 500;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 12px 25px rgba(67, 97, 238, 0.35);
    }
    .btn-primary:hover {
        background-color: #3f51b5;
        transform: translateY(-2px);
        box-shadow: 0 16px 30px rgba(63, 81, 181, 0.45);
    }
    .btn-google {
        border-radius: 12px;
        padding: 12px;
        font-weight: 500;
        border: 2px solid #eee;
        color: #555;
        transition: all 0.2s;
    }
    .btn-google:hover {
        background-color: #fff1f1;
        border-color: #dc3545;
        color: #dc3545;
    }
    .divider-text {
        position: relative;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .divider-text span {
        padding: 7px 14px;
        font-size: 12px;
        position: relative;
        z-index: 2;
        background-color: #fff;
        color: #adb5bd;
        border-radius: 999px;
    }
    .divider-text:after {
        content: "";
        position: absolute;
        width: 100%;
        border-bottom: 1px solid #eee;
        top: 55%;
        left: 0;
        z-index: 1;
    }
    .form-text { font-size: 0.85rem; color: #6c757d; }
</style>
@endpush

@section('content')
<div class="container py-5" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card bg-white">
                <div class="card-body p-4 p-md-5">

                    <div class="login-header text-center mb-4">
                        <h3>Login</h3>
                        <p class="mb-0">Selamat datang kembali di AspirasiKu!</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email Input --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">
                                <i class="fa-solid fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Masukkan email di sini" value="{{ old('email') }}" required autofocus>
                            <div class="form-text mb-3">
                                <i class="fa-solid fa-circle-info me-1"></i> Gunakan email <strong>@mail.unej.ac.id</strong>.
                            </div>
                        </div>

                        {{-- Password Input --}}
                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold">
                                <i class="fa-solid fa-key me-1"></i> Password
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="login_password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password di sini" required>
                                <button class="btn btn-toggle-password toggle-password" type="button" data-target="login_password">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </button>
                    </form>

                    <div class="divider-text"><span>atau</span></div>

                    <a href="{{ route('google.redirect') }}" class="btn btn-google w-100 mb-4 bg-white">
                        <i class="fa-brands fa-google me-2"></i> Login dengan Google
                    </a>

                    <div class="text-center">
                        <span class="text-muted small">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #4361EE;">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            let errorMsg = '';
            @foreach ($errors->all() as $error)
                errorMsg += '{{ $error }}<br>';
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                html: errorMsg,
                confirmButtonColor: '#4361EE'
            });
        @endif
    });
</script>
@endpush
@endsection