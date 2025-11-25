@extends('layouts.app')

@section('title', 'Kelola Tipe Berita')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fa-solid fa-layer-group text-primary me-2"></i>
                Kelola Tipe Berita
            </h2>
            <p class="text-muted mb-0">Atur tipe berita untuk pengelompokan di modul berita.</p>
        </div>
        <a href="{{ route('admin.news-types.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-circle-plus me-1"></i> Tambah Tipe
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Tipe</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Berita</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($types as $type)
                            <tr>
                                <td><strong>{{ $type->name }}</strong></td>
                                <td>{{ Str::limit($type->description, 80) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $type->news_count }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.news-types.edit', $type) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.news-types.destroy', $type) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus tipe ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada tipe berita.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection