@extends('layouts.app')

@section('title', 'Detail Aspirasi Publik')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card mb-3">
                <div class="card-body">
                    <span class="badge bg-success mb-2">Completed</span>
                    <h3>{{ $aspiration->title }}</h3>
                    <p class="text-muted">
                        <i class="bi bi-person"></i> 
                        @if($aspiration->is_anonymous)
                            Anonymous
                        @else
                            {{ $aspiration->user->name }}
                        @endif
                        <span class="mx-2">•</span>
                        <i class="bi bi-tag"></i> {{ $aspiration->category->name }}
                        <span class="mx-2">•</span>
                        <i class="bi bi-calendar"></i> {{ $aspiration->created_at->format('d M Y') }}
                    </p>

                    <hr>

                    <h5>Deskripsi</h5>
                    <p style="white-space: pre-line;">{{ $aspiration->description }}</p>

                    @if($aspiration->attachments->count() > 0)
                        <h5 class="mt-4">Lampiran</h5>
                        <div class="list-group">
                            @foreach($aspiration->attachments as $attachment)
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="list-group-item list-group-item-action">
                                    <i class="bi bi-file-earmark"></i> {{ $attachment->file_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($aspiration->responses->where('sender_type', 'admin')->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tanggapan Admin</h5>
                    </div>
                    <div class="card-body">
                        @foreach($aspiration->responses->where('sender_type', 'admin') as $response)
                            <div class="card mb-3 border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>
                                            <i class="bi bi-shield-check text-primary"></i> {{ $response->user->name }}
                                            <span class="badge bg-primary">{{ strtoupper($response->user->role) }}</span>
                                        </strong>
                                        <small class="text-muted">{{ $response->created_at->format('d M Y') }}</small>
                                    </div>
                                    <p>{{ $response->message }}</p>

                                    @if($response->attachments->count() > 0)
                                        <div class="mt-2">
                                            <small class="text-muted">Lampiran:</small>
                                            @foreach($response->attachments as $attachment)
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="badge bg-secondary me-1">
                                                    <i class="bi bi-paperclip"></i> {{ $attachment->file_name }}
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
