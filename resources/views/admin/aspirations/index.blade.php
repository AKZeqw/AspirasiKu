@extends('layouts.app')

@section('title', 'Kelola Aspirasi')

@section('content')
<div class="container">
    <h2 class="mb-4">Kelola Aspirasi</h2>

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.aspirations.index') }}" class="row g-3">
                <div class="col-md-4">
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
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.aspirations.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- List -->
    @if($aspirations->count() > 0)
        <div class="row">
            @foreach($aspirations as $aspiration)
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">{{ $aspiration->title }}</h5>
                                <span class="badge status-{{ $aspiration->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                                </span>
                            </div>
                            <p class="text-muted mb-2">
                                <i class="bi bi-person"></i> 
                                @if($aspiration->is_anonymous)
                                    Anonymous
                                @else
                                    {{ $aspiration->user->name }}
                                @endif
                                <span class="mx-2">•</span>
                                <i class="bi bi-tag"></i> {{ $aspiration->category->name }}
                            </p>
                            <p class="card-text">{{ Str::limit($aspiration->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $aspiration->created_at->diffForHumans() }}</small>
                                <a href="{{ route('admin.aspirations.show', $aspiration) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $aspirations->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="mt-3">Tidak Ada Aspirasi</h4>
                <p class="text-muted">Belum ada aspirasi dengan filter ini</p>
            </div>
        </div>
    @endif
</div>
@endsection
