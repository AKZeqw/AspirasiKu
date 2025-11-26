@extends('layouts.app')

@section('title', 'Kelola Aspirasi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fa-solid fa-inbox text-primary me-2"></i>
                Kelola Aspirasi
            </h2>
            <p class="text-muted mb-0">Pantau dan proses aspirasi yang masuk dari mahasiswa.</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.aspirations.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="fa-solid fa-signal me-1 text-secondary"></i> Status
                    </label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="fa-solid fa-tags me-1 text-secondary"></i> Kategori
                    </label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fa-solid fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin.aspirations.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- List --}}
    @if($aspirations->count() > 0)
        <div class="row">
            @foreach($aspirations as $aspiration)
                <div class="col-md-6 mb-3">
                    <div class="card h-100 border-0 shadow-sm aspiration-card">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0 text-truncate" title="{{ $aspiration->title }}">
                                    <i class="fa-solid fa-lightbulb text-warning me-1"></i>
                                    {{ $aspiration->title }}
                                </h5>
                                <span class="badge status-{{ $aspiration->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                                </span>
                            </div>
                            <p class="text-muted mb-2 small">
                                <i class="fa-solid fa-user me-1"></i>
                                @if($aspiration->is_anonymous)
                                    Anonymous
                                @else
                                    {{ $aspiration->user->name }}
                                @endif
                                <span class="mx-2">•</span>
                                <i class="fa-solid fa-tag me-1"></i> {{ $aspiration->category->name }}
                            </p>
                            <p class="card-text flex-grow-1">
                                {{ Str::limit($aspiration->description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                <small class="text-muted">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    {{ $aspiration->created_at->diffForHumans() }}
                                </small>
                                <a href="{{ route('admin.aspirations.show', $aspiration) }}"
                                   class="btn btn-sm btn-outline-primary">
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
                <h4 class="mt-2">Tidak Ada Aspirasi</h4>
                <p class="text-muted mb-0">Belum ada aspirasi dengan filter ini.</p>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .aspiration-card {
        border-radius: 0.9rem;
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .aspiration-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.9rem 1.6rem rgba(15, 23, 42, 0.12);
    }
</style>
@endpush
@endsection
