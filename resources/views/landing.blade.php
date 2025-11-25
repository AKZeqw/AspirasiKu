@extends('layouts.app')

@section('title', 'AspirasiKu - Sistem Aspirasi Mahasiswa UNEJ')

@section('content')
<div class="bg-light">
    {{-- Hero Section --}}
    <section class="py-5 py-md-6">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-md-6">
                    <span class="badge bg-primary-subtle text-primary border border-primary mb-3">
                        <i class="fa-solid fa-bullhorn me-1"></i> Platform Aspirasi Mahasiswa
                    </span>
                    <h1 class="fw-bold mb-3">
                        Suarakan Aspirasimu,<br>
                        <span class="text-primary">Bangun Kampus yang Lebih Baik</span>
                    </h1>
                    <p class="text-muted mb-4">
                        AspirasiKu membantu mahasiswa Universitas Jember menyampaikan kritik, saran, dan keluhan secara terstruktur,
                        transparan, dan dapat ditindaklanjuti oleh pihak kampus.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Mulai Login
                            </a>
                            <a href="{{ route('public.aspirations') }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-eye me-1"></i> Lihat Aspirasi Publik
                            </a>
                        @else
                            <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-circle-plus me-1"></i> Buat Aspirasi
                            </a>
                            <a href="{{ route('mahasiswa.aspirations.index') }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-list me-1"></i> Lihat Aspirasi Saya
                            </a>
                        @endguest
                    </div>
                    <div class="text-muted small">
                        <i class="fa-solid fa-shield-halved me-1"></i>
                        Data terlindungi, bisa kirim secara anonim jika diperlukan.
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4">
                            <h5 class="mb-3">
                                <i class="fa-solid fa-chart-line me-1 text-primary"></i>
                                Ringkasan Aktivitas
                            </h5>
                            <div class="row text-center g-3">
                                <div class="col-4">
                                    <div class="p-3 rounded bg-primary-subtle">
                                        <i class="fa-solid fa-comments text-primary mb-1"></i>
                                        <h5 class="mb-0">{{ $stats['total'] ?? '—' }}</h5>
                                        <small class="text-muted">Aspirasi</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded bg-warning-subtle">
                                        <i class="fa-solid fa-gears text-warning mb-1"></i>
                                        <h5 class="mb-0">{{ $stats['in_progress'] ?? '—' }}</h5>
                                        <small class="text-muted">Diproses</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded bg-success-subtle">
                                        <i class="fa-solid fa-circle-check text-success mb-1"></i>
                                        <h5 class="mb-0">{{ $stats['completed'] ?? '—' }}</h5>
                                        <small class="text-muted">Selesai</small>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted small mt-3 mb-0">
                                Angka di atas hanya ilustrasi, bisa diisi dari query statistik aspirasi pada controller landing page.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fitur Section --}}
    <section class="py-5 border-top bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <h3 class="mb-1">Kenapa Menggunakan AspirasiKu?</h3>
                <p class="text-muted mb-0">Dirancang khusus untuk kebutuhan mahasiswa UNEJ.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fa-solid fa-lock text-primary fa-2x"></i>
                            </div>
                            <h5>Anonim & Aman</h5>
                            <p class="text-muted small mb-0">
                                Pilih mode anonim saat mengirim aspirasi, identitasmu tidak akan ditampilkan di publik tetapi tetap tercatat untuk verifikasi internal.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fa-solid fa-sitemap text-success fa-2x"></i>
                            </div>
                            <h5>Kategori Terstruktur</h5>
                            <p class="text-muted small mb-0">
                                Aspirasi dikelompokkan per kategori (fasilitas, akademik, keuangan, dll.) sehingga mudah dipetakan dan ditangani pihak kampus.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fa-solid fa-timeline text-warning fa-2x"></i>
                            </div>
                            <h5>Monitoring Progres</h5>
                            <p class="text-muted small mb-0">
                                Pantau status aspirasi (draft, submitted, in progress, completed) dan baca tanggapan resmi dari admin kapan saja.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-5 border-top">
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-md-8">
                    <h4 class="mb-1">
                        Siap menyampaikan aspirasimu?
                    </h4>
                    <p class="text-muted mb-0">
                        Gunakan bahasa yang santun, jelas, dan bertanggung jawab agar aspirasimu lebih mudah ditindaklanjuti.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary me-2 mb-2 mb-md-0">
                            <i class="fa-solid fa-user-plus me-1"></i> Daftar
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </a>
                    @else
                        <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-circle-plus me-1"></i> Buat Aspirasi Sekarang
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    /* Sedikit styling khusus landing */
    .py-md-6 { padding-top: 4.5rem; padding-bottom: 4.5rem; }
    @media (min-width: 768px) {
        .py-md-6 { padding-top: 5.5rem; padding-bottom: 5.5rem; }
    }
</style>
@endpush
@endsection
