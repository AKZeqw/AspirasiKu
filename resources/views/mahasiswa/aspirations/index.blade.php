@extends('layouts.app')

@section('title', 'Aspirasi Saya')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Aspirasi Saya</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Buat Aspirasi
            </a>
        </div>
    </div>

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
                                <i class="bi bi-tag"></i> {{ $aspiration->category->name }}
                            </p>
                            <p class="card-text">{{ Str::limit($aspiration->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $aspiration->created_at->diffForHumans() }}</small>
                                <div>
                                    <a href="{{ route('mahasiswa.aspirations.show', $aspiration) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    @if(in_array($aspiration->status, ['draft', 'submitted']))
                                        <a href="{{ route('mahasiswa.aspirations.edit', $aspiration) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    @endif
                                </div>
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
                <h4 class="mt-3">Belum Ada Aspirasi</h4>
                <p class="text-muted">Mulai buat aspirasi pertama Anda sekarang!</p>
                <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Aspirasi
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
