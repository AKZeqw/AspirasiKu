@extends('layouts.app')

@section('title', isset($newsType) ? 'Edit Tipe Berita' : 'Tambah Tipe Berita')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="mb-3">
                <h2 class="mb-1">
                    <i class="fa-solid fa-layer-group text-primary me-2"></i>
                    {{ isset($newsType) ? 'Edit Tipe Berita' : 'Tambah Tipe Berita' }}
                </h2>
                <p class="text-muted mb-0">
                    Tipe berita akan muncul sebagai pilihan di form berita.
                </p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($newsType) ? route('admin.news-types.update', $newsType) : route('admin.news-types.store') }}">
                        @csrf
                        @if(isset($newsType))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">
                                Nama Tipe <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $newsType->name ?? '') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi (opsional)</label>
                            <textarea name="description"
                                      rows="3"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $newsType->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Ditampilkan ke admin sebagai penjelasan fungsi tipe ini.
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                            </button>
                            <a href="{{ route('admin.news-types.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection