@extends('layouts.app')

@section('title', 'Aspirasi Publik')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Aspirasi Publik</h2>
            <p class="text-muted">Lihat aspirasi yang telah diselesaikan</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('public.aspirations') }}" class="row g-3">
                <div class="col-md-6">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('public.aspirations') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    @if($aspirations->count() > 0)
        <div class="row">
            @foreach($aspirations as $aspiration)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $aspiration->title }}</h5>
                            <p class="text-muted mb-2">
                                <i class="bi bi-person"></i> 
                                @if($aspiration->is_anonymous)
                                    Anonymous
                                @else
                                    {{ $aspiration->user->name }}
                                @endif
                                <br>
                                <i class="bi bi-tag"></i> {{ $aspiration->category->name }}
                            </p>
                            <p class="card-text">{{ Str::limit($aspiration->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $aspiration->created_at->format('d M Y') }}</small>
                                <a href="{{ route('public.aspirations.show', $aspiration) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Lihat Detail
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
                <h4 class="mt-3">Tidak Ada Aspirasi Publik</h4>
                <p class="text-muted">Belum ada aspirasi yang diselesaikan</p>
            </div>
        </div>
    @endif
</div>
@endsection
