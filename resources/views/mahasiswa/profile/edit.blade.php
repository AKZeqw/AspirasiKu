@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Edit Profil -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Edit Profil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mahasiswa.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" 
                                   value="{{ old('nim', auth()->user()->nim) }}" maxlength="12" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ganti Password</h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->password)
                        <form method="POST" action="{{ route('mahasiswa.profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key"></i> Ganti Password
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Anda login menggunakan Google. Password tidak diperlukan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
