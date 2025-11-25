@extends('layouts.app')

@section('title', 'Register - AspirasiKu')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    body {
        background-color: #e8ecf3;
        font-family: 'Poppins', sans-serif;
    }
    
    .register-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .register-header h3 {
        font-weight: 600;
        color: #2B2D42;
    }

    .register-header p {
        color: #8D99AE;
        font-size: 0.9rem;
    }

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

    .btn-primary {
        background-color: #4361EE;
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 500;
        transition: transform 0.2s;
    }

    .btn-primary:hover {
        background-color: #3f51b5;
        transform: translateY(-2px);
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
        padding: 7px;
        font-size: 12px;
        position: relative;
        z-index: 2;
        background-color: #fff;
        color: #adb5bd;
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

    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    .invalid-feedback {
        font-size: 0.85rem;
        color: #dc3545;
        display: block;
        margin-top: 0.5rem;
    }

</style>

<div class="container py-5" style="min-height: 85vh; display: flex; align-items: center;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5">
            <div class="card register-card bg-white">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Header Section --}}
                    <div class="register-header text-center mb-4">
                        <h3>Daftar Akun</h3>
                        <p class="mb-0">Bergabunglah dengan AspirasiKu sekarang!</p>
                    </div>
                    
                    {{-- Form Start --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        {{-- Nama Lengkap Input --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email UNEJ Input --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Email UNEJ</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" placeholder="nim@mail.unej.ac.id" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i> Harus menggunakan email @mail.unej.ac.id
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIM Input --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">NIM</label>
                            <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" 
                                   placeholder="12 digit" value="{{ old('nim') }}" maxlength="12" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Input --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Masukkan password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password Input --}}
                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   placeholder="Ulangi password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">
                            Daftar Akun
                        </button>
                    </form>

                    <div class="divider-text">
                        <span>atau</span>
                    </div>

                    {{-- Google Register Button --}}
                    <a href="{{ route('google.redirect') }}" class="btn btn-google w-100 mb-4 bg-white">
                        <i class="bi bi-google me-2"></i> Daftar dengan Google
                    </a>

                    <div class="text-center">
                        <span class="text-muted small">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #4361EE;">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 Script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            let errorMsg = '';
            @foreach ($errors->all() as $error)
                errorMsg += '{{ $error }}<br>';
            @endforeach
            
            Swal.fire({
                icon: 'error',
                title: 'Registrasi Gagal',
                html: errorMsg,
                confirmButtonColor: '#4361EE'
            });
        @endif
    });
</script>

@endsection
