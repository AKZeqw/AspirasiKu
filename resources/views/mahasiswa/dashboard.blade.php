@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="mb-1">
                <i class="fa-solid fa-gauge-high text-primary me-2"></i>
                Dashboard Mahasiswa
            </h2>
            <p class="text-muted mb-0">
                Selamat datang, <span class="fw-semibold">{{ auth()->user()->name }}</span>!
            </p>
        </div>
        <div class="col-auto">
            <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus me-1"></i> Buat Aspirasi Baru
            </a>
        </div>
    </div>

    {{-- Kartu statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg,#2563eb,#4f46e5);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-white-50 text-uppercase">Total Aspirasi</span>
                        <i class="fa-solid fa-comments fa-lg"></i>
                    </div>
                    <h2 class="fw-bold mb-0">{{ auth()->user()->aspirations()->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg,#f59e0b,#f97316);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-white-50 text-uppercase">Draft</span>
                        <i class="fa-solid fa-file-pen fa-lg"></i>
                    </div>
                    <h2 class="fw-bold mb-0">
                        {{ auth()->user()->aspirations()->where('status', 'draft')->count() }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg,#06b6d4,#0ea5e9);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-white-50 text-uppercase">Diproses</span>
                        <i class="fa-solid fa-gears fa-lg"></i>
                    </div>
                    <h2 class="fw-bold mb-0">
                        {{ auth()->user()->aspirations()->whereIn('status', ['submitted', 'under_review', 'in_progress'])->count() }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg,#10b981,#22c55e);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-white-50 text-uppercase">Selesai</span>
                        <i class="fa-solid fa-circle-check fa-lg"></i>
                    </div>
                    <h2 class="fw-bold mb-0">
                        {{ auth()->user()->aspirations()->where('status', 'completed')->count() }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel aspirasi terbaru --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>
                Aspirasi Terbaru
            </h5>
            <small class="text-muted">
                Menampilkan {{ $aspirations->count() }} aspirasi terakhir
            </small>
        </div>
        <div class="card-body">
            @if($aspirations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspirations as $aspiration)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $aspiration->title }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary">
                                            <i class="fa-solid fa-tag me-1"></i>
                                            {{ $aspiration->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge status-{{ $aspiration->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fa-regular fa-calendar me-1 text-muted"></i>
                                        {{ $aspiration->created_at->format('d M Y') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('mahasiswa.aspirations.show', $aspiration) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fa-regular fa-face-smile-beam fa-3x mb-3" style="color:#9ca3af;"></i>
                    <p class="text-muted mb-1">Belum ada aspirasi yang kamu buat.</p>
                    <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-circle-plus me-1"></i> Buat sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
