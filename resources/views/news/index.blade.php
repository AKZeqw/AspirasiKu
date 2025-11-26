@extends('layouts.app')

@section('title', 'Berita Kampus')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="mb-1">
                <i class="fa-solid fa-newspaper text-primary me-2"></i>
                Berita Kampus & Informasi
            </h2>
            <p class="text-muted mb-0">
                Open recruitment, perlombaan, prestasi, acara kampus, beasiswa, dan pengumuman lainnya.
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('news.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="fa-solid fa-layer-group me-1 text-secondary"></i>
                        Tipe Berita
                    </label>
                    <select name="type" class="form-select">
                        <option value="">Semua Tipe</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ (string)request('type') === (string)$type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="fa-solid fa-magnifying-glass me-1 text-secondary"></i>
                        Pencarian (opsional)
                    </label>
                    <input type="text"
                           name="q"
                           class="form-control"
                           value="{{ request('q') }}"
                           placeholder="Cari judul berita...">
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-primary me-2">
                        <i class="fa-solid fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- List berita --}}
    @if($news->count() > 0)
        <div class="row">
            @foreach($news as $item)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm news-card">
                        @if($item->cover_image)
                            <img src="{{ asset('storage/'.$item->cover_image) }}"
                                 class="card-img-top"
                                 alt="{{ $item->title }}"
                                 style="object-fit: cover; max-height: 180px;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <span class="badge mb-2 {{ $item->type_badge_class ?? 'bg-secondary' }}">
                                {{ $item->type_label ?? ucfirst(str_replace('_', ' ', $item->type)) }}
                            </span>
                            <h5 class="card-title mb-1 text-truncate" title="{{ $item->title }}">
                                {{ $item->title }}
                            </h5>
                            <small class="text-muted mb-2">
                                <i class="fa-regular fa-calendar-days me-1"></i>
                                {{ optional($item->published_at)->format('d M Y') }}
                            </small>
                            <p class="card-text flex-grow-1">
                                {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 100) }}
                            </p>
                            <a href="{{ route('news.show', $item->id) }}"
                               class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fa-solid fa-eye me-1"></i> Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fa-regular fa-newspaper fa-4x mb-3" style="color:#cbd5e1;"></i>
                <h4 class="mt-2">Belum Ada Berita</h4>
                <p class="text-muted mb-0">Belum ada berita yang dipublikasikan saat ini.</p>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .news-card {
        border-radius: 0.9rem;
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .news-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.9rem 1.6rem rgba(15, 23, 42, 0.12);
    }
</style>
@endpush
@endsection