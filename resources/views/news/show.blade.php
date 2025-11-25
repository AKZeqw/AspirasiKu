@extends('layouts.app')

@section('title', $news->title.' - Berita Kampus')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('news.index') }}">
                            <i class="fa-solid fa-newspaper me-1"></i> Berita
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Str::limit($news->title, 40) }}
                    </li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm mb-3">
                @if($news->cover_image)
                    <a href="#"
                       data-bs-toggle="modal"
                       data-bs-target="#coverModal">
                        {{-- Di halaman ini, biarkan rasio asli --}}
                        <img src="{{ asset('storage/'.$news->cover_image) }}"
                             class="card-img-top img-fluid"
                             alt="{{ $news->title }}"
                             style="width: 100%; height: auto; cursor: zoom-in;">
                    </a>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge {{ $news->type_badge_class ?? 'bg-secondary' }} mb-2">
                                {{ $news->type_label ?? ucfirst(str_replace('_', ' ', $news->type)) }}
                            </span>
                            <h2 class="mb-1">{{ $news->title }}</h2>
                            <p class="text-muted small mb-0">
                                <i class="fa-regular fa-calendar-days me-1"></i>
                                {{ optional($news->published_at)->format('d M Y, H:i') }}
                                @if($news->author)
                                    <span class="mx-2">•</span>
                                    <i class="fa-solid fa-user-pen me-1"></i>
                                    {{ $news->author->name }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <article class="news-content">
                        {!! nl2br(e($news->content)) !!}
                    </article>
                </div>
            </div>

        </div>
    </div>
</div>

@if($news->cover_image)
    <!-- Modal fullscreen untuk gambar cover + zoom scroll + drag (hold to pan) -->
    <div class="modal fade" id="coverModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black bg-opacity-75 border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">
                        {{ $news->title }}
                    </h5>
                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="zoom-container"
                         class="w-100 h-100 d-flex justify-content-center align-items-center overflow-hidden"
                         style="cursor: grab;">
                        <img id="zoom-image"
                             src="{{ asset('storage/'.$news->cover_image) }}"
                             alt="{{ $news->title }}"
                             class="img-fluid"
                             style="
                                width: 100%;
                                height: 100%;
                                object-fit: contain;
                                transform-origin: center center;
                                transform: translate(0px, 0px) scale(1);
                             ">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
@if($news->cover_image)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('zoom-container');
        const img = document.getElementById('zoom-image');
        const coverModal = document.getElementById('coverModal');
        if (!container || !img || !coverModal) return;

        let scale = 1;
        const minScale = 1;
        const maxScale = 5;
        const zoomStep = 0.2;

        let isDragging = false;
        let startX = 0;
        let startY = 0;
        let translateX = 0;
        let translateY = 0;
        let lastTranslateX = 0;
        let lastTranslateY = 0;

        function applyTransform() {
            img.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
        }

        // Zoom dengan scroll wheel
        container.addEventListener('wheel', function (e) {
            e.preventDefault();

            const delta = e.deltaY < 0 ? 1 : -1;
            scale += delta * zoomStep;
            if (scale < minScale) scale = minScale;
            if (scale > maxScale) scale = maxScale;

            if (scale === minScale) {
                translateX = 0;
                translateY = 0;
                lastTranslateX = 0;
                lastTranslateY = 0;
            }

            applyTransform();
        }, { passive: false });

        // Mulai drag hanya saat mouse kiri ditekan
        container.addEventListener('mousedown', function (e) {
            if (e.button !== 0) return;       // hanya tombol kiri
            if (scale === 1) return;          // tidak perlu geser kalau belum di-zoom

            isDragging = true;
            container.style.cursor = 'grabbing';
            startX = e.clientX - lastTranslateX;
            startY = e.clientY - lastTranslateY;
        });

        // Geser saat mouse bergerak dan masih ditekan
        window.addEventListener('mousemove', function (e) {
            if (!isDragging) return;

            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            lastTranslateX = translateX;
            lastTranslateY = translateY;
            applyTransform();
        });

        // Lepas drag saat mouse up (dimanapun)
        window.addEventListener('mouseup', function (e) {
            if (e.button !== 0) return;
            if (!isDragging) return;

            isDragging = false;
            container.style.cursor = 'grab';
        });

        // Reset zoom & posisi saat modal ditutup
        coverModal.addEventListener('hidden.bs.modal', function () {
            scale = 1;
            translateX = 0;
            translateY = 0;
            lastTranslateX = 0;
            lastTranslateY = 0;
            applyTransform();
            container.style.cursor = 'grab';
        });
    });
</script>
@endif
@endpush
