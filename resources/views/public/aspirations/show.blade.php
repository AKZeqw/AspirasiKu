@extends('layouts.app')

@section('title', 'Detail Aspirasi Publik')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">

            {{-- Breadcrumb sederhana --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('public.aspirations') }}">
                            <i class="fa-solid fa-chevron-left me-1"></i> Kembali ke daftar
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Aspirasi
                    </li>
                </ol>
            </nav>

            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-success-subtle text-success border border-success">
                            <i class="fa-solid fa-circle-check me-1"></i> Completed
                        </span>
                        <small class="text-muted">
                            <i class="fa-regular fa-calendar me-1"></i>
                            {{ $aspiration->created_at->format('d M Y') }}
                        </small>
                    </div>

                    <h3 class="mb-2">
                        <i class="fa-solid fa-lightbulb text-warning me-2"></i>
                        {{ $aspiration->title }}
                    </h3>

                    <p class="text-muted mb-3 small">
                        <i class="fa-solid fa-user me-1"></i>
                        @if($aspiration->is_anonymous)
                            Anonymous
                        @else
                            {{ $aspiration->user->name }}
                        @endif
                        <span class="mx-2">•</span>
                        <i class="fa-solid fa-tag me-1"></i> {{ $aspiration->category->name }}
                    </p>

                    <hr>

                    <h5 class="mb-2">
                        <i class="fa-solid fa-align-left me-1"></i> Deskripsi
                    </h5>
                    <p class="mb-0" style="white-space: pre-line;">{{ $aspiration->description }}</p>

                    @if($aspiration->attachments->count() > 0)
                        <hr class="mt-4">
                        <h5 class="mb-2">
                            <i class="fa-solid fa-paperclip me-1"></i> Lampiran
                        </h5>
                        <div class="list-group">
                            @foreach($aspiration->attachments as $attachment)
                                <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                   target="_blank"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fa-regular fa-file-lines me-2"></i>
                                        {{ $attachment->file_name }}
                                    </span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-muted"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($aspiration->responses->where('sender_type', 'admin')->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="fa-solid fa-shield-halved text-primary me-2"></i>
                        <h5 class="mb-0">Tanggapan Admin</h5>
                    </div>
                    <div class="card-body">
                        @foreach($aspiration->responses->where('sender_type', 'admin') as $response)
                            <div class="card mb-3 border-primary-subtle">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <strong>
                                                <i class="fa-solid fa-user-shield text-primary me-1"></i>
                                                {{ $response->user->name }}
                                            </strong>
                                            <span class="badge bg-primary ms-1">
                                                {{ strtoupper($response->user->role) }}
                                            </span>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa-regular fa-calendar-days me-1"></i>
                                            {{ $response->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                    <p class="mb-2">{{ $response->message }}</p>

                                    @if($response->attachments->count() > 0)
                                        <div class="mt-2">
                                            <small class="text-muted d-block mb-1">
                                                <i class="fa-solid fa-paperclip me-1"></i> Lampiran:
                                            </small>
                                            @foreach($response->attachments as $attachment)
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                   target="_blank"
                                                   class="badge bg-secondary text-decoration-none me-1 mb-1">
                                                    <i class="fa-regular fa-file-lines me-1"></i>
                                                    {{ $attachment->file_name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
