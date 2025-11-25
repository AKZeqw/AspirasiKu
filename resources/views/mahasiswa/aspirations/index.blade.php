@extends('layouts.app')

@section('title', 'Aspirasi Saya')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="mb-1">
                <i class="fa-solid fa-comment-dots text-primary me-2"></i>
                Aspirasi Saya
            </h2>
            <p class="text-muted mb-0">Daftar semua aspirasi yang pernah kamu kirim.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus me-1"></i> Buat Aspirasi
            </a>
        </div>
    </div>

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
                                <div class="d-flex gap-1">
                                    <a href="{{ route('mahasiswa.aspirations.show', $aspiration) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-eye me-1"></i> Detail
                                    </a>
                                    @if(in_array($aspiration->status, ['draft', 'submitted']))
                                        <a href="{{ route('mahasiswa.aspirations.edit', $aspiration) }}"
                                           class="btn btn-sm btn-outline-warning border-warning">
                                            <i class="fa-solid fa-pen me-1"></i> Edit
                                        </a>
                                    @endif
                                </div>
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
                <i class="fa-regular fa-inbox fa-4x mb-3" style="color:#ccc;"></i>
                <h4 class="mt-2">Belum Ada Aspirasi</h4>
                <p class="text-muted mb-3">Mulai buat aspirasi pertama kamu sekarang.</p>
                <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-circle-plus me-1"></i> Buat Aspirasi
                </a>
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
