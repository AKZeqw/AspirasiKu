@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="mb-4">
                <h2 class="mb-1">
                    <i class="fa-solid fa-user-gear text-primary me-2"></i> Edit Profil
                </h2>
                <p class="text-muted mb-0">Perbarui data akun dan keamanan login kamu.</p>
            </div>

            {{-- Edit Profil --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fa-solid fa-id-card me-2 text-primary"></i>
                    <h5 class="mb-0">Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mahasiswa.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-signature me-1 text-secondary"></i> Nama Lengkap
                            </label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-envelope me-1 text-secondary"></i> Email
                            </label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-id-badge me-1 text-secondary"></i> NIM
                            </label>
                            <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                   value="{{ old('nim', auth()->user()->nim) }}" maxlength="12" required>
                            @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ganti Password --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fa-solid fa-key me-2 text-warning"></i>
                    <h5 class="mb-0">Keamanan Akun</h5>
                </div>
                <div class="card-body">
                    <form id="form-update-password" method="POST" action="{{ route('mahasiswa.profile.password') }}">
                        @csrf
                        @method('PUT')

                        @if(empty(auth()->user()->google_id))
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fa-solid fa-lock me-1 text-secondary"></i> Password Saat Ini
                                </label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="mhs_current_password"
                                           class="form-control @error('current_password') is-invalid @enderror" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="mhs_current_password">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mb-3 d-flex align-items-center">
                                <i class="fa-solid fa-circle-info me-2 fs-4"></i>
                                <div>
                                    <strong>Anda login menggunakan Google.</strong><br>
                                    Anda dapat membuat password khusus untuk akun AspirasiKu di bawah ini.
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fa-solid fa-key me-1 text-secondary"></i> Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" id="mhs_new_password"
                                           class="form-control @error('password') is-invalid @enderror" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="mhs_new_password">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fa-solid fa-key me-1 text-secondary"></i> Konfirmasi Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="mhs_confirm_password"
                                           class="form-control" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="mhs_confirm_password">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fa-solid fa-arrows-rotate me-1"></i>
                            {{ empty(auth()->user()->google_id) ? 'Ganti Password' : 'Buat Password' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('form-update-password');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Ganti password?',
                    text: 'Pastikan password baru aman dan mudah diingat.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb', 
                    cancelButtonColor: '#6b7280',  
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        }
    });
</script>
@endpush
@endsection