@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Dashboard Mahasiswa</h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('mahasiswa.aspirations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Buat Aspirasi Baru
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Aspirasi</h5>
                    <h2>{{ auth()->user()->aspirations()->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Draft</h5>
                    <h2>{{ auth()->user()->aspirations()->where('status', 'draft')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Diproses</h5>
                    <h2>{{ auth()->user()->aspirations()->whereIn('status', ['submitted', 'under_review', 'in_progress'])->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <h2>{{ auth()->user()->aspirations()->where('status', 'completed')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Aspirasi Terbaru</h5>
        </div>
        <div class="card-body">
            @if($aspirations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspirations as $aspiration)
                                <tr>
                                    <td>{{ $aspiration->title }}</td>
                                    <td>{{ $aspiration->category->name }}</td>
                                    <td>
                                        <span class="badge status-{{ $aspiration->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $aspiration->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('mahasiswa.aspirations.show', $aspiration) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-4">Belum ada aspirasi. <a href="{{ route('mahasiswa.aspirations.create') }}">Buat sekarang</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
