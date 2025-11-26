@extends('layouts.app')

@section('title', 'Aspirasi Publik')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="fa-solid fa-comments text-primary me-2"></i>
                Aspirasi Publik
            </h2>
            <p class="text-muted mb-0">Lihat aspirasi yang telah diselesaikan oleh pihak terkait.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill">
                <i class="fa-solid fa-circle-check me-1"></i>
                Aspirasi Terselesaikan
            </span>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('public.aspirations') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fa-solid fa-filter me-1 text-primary"></i> Filter Kategori
                    </label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 text-md-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('public.aspirations') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($aspirations->count() > 0)
        <div class="row">
            @foreach($aspirations as $aspiration)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm border-0 aspiration-card">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0 text-truncate" title="{{ $aspiration->title }}">
                                    <i class="fa-solid fa-lightbulb text-warning me-1"></i>
                                    {{ $aspiration->title }}
                                </h5>
                                <span class="badge bg-success-subtle text-success border border-success">
                                    <i class="fa-solid fa-circle-check me-1"></i>Selesai
                                </span>
                            </div>

                            <p class="text-muted small mb-2">
                                <i class="fa-solid fa-user me-1"></i>
                                @if($aspiration->is_anonymous)
                                    Anonymous
                                @else
                                    {{ $aspiration->user->name }}
                                @endif
                                <br>
                                <i class="fa-solid fa-tags me-1"></i> {{ $aspiration->category->name }}
                            </p>

                            <p class="card-text flex-grow-1">
                                {{ Str::limit($aspiration->description, 120) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                <small class="text-muted">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ $aspiration->created_at->format('d M Y') }}
                                </small>
                                <a href="{{ route('public.aspirations.show', $aspiration) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $aspirations->links() }}
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fa-regular fa-inbox fa-4x mb-3" style="color:#cbd5e1;"></i>
                <h4 class="mt-2">Tidak Ada Aspirasi Publik</h4>
                <p class="text-muted mb-0">Belum ada aspirasi yang diselesaikan. Silakan kembali lagi nanti.</p>
            </div>
        </div>
    @endif
</div>

{{-- Optional: custom style untuk kartu --}}
@push('styles')
<style>
    .aspiration-card {
        transition: transform .15s ease, box-shadow .15s ease;
        border-radius: 0.8rem;
    }
    .aspiration-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.75rem 1.5rem rgba(15, 23, 42, 0.12);
    }
</style>
@endpush
@endsection
