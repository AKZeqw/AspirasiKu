@extends('layouts.app')

@section('title', 'Login - AspirasiKu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Login</h3>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    </form>

                    <div class="text-center mb-3">
                        <span class="text-muted">atau</span>
                    </div>

                    <a href="{{ route('google.redirect') }}" class="btn btn-outline-danger w-100 mb-3">
                        <i class="bi bi-google"></i> Login dengan Google
                    </a>

                    <div class="text-center">
                        <span class="text-muted">Belum punya akun?</span>
                        <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
