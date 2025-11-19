@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Admin Dashboard</h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Aspirasi</h5>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Submitted</h5>
                    <h2>{{ $stats['submitted'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <h2>{{ $stats['in_progress'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <h2>{{ $stats['completed'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Aspirasi Terbaru</h5>
        </div>
        <div class="card-body">
            @if($recent->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Mahasiswa</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent as $aspiration)
                                <tr>
                                    <td>{{ Str::limit($aspiration->title, 40) }}</td>
                                    <td>
                                        @if($aspiration->is_anonymous)
                                            <i class="bi bi-incognito"></i> Anonymous
                                        @else
                                            {{ $aspiration->user->name }}
                                        @endif
                                    </td>
                                    <td>{{ $aspiration->category->name }}</td>
                                    <td>
                                        <span class="badge status-{{ $aspiration->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $aspiration->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.aspirations.show', $aspiration) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-4">Tidak ada aspirasi terbaru</p>
            @endif
        </div>
    </div>
</div>
@endsection
