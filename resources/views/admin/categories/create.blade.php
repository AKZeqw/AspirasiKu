@extends('layouts.app')

@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Header --}}
            <div class="mb-3">
                <h2 class="mb-1">
                    <i class="fa-solid fa-tags text-primary me-2"></i>
                    {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}
                </h2>
                <p class="text-muted mb-0">
                    Atur nama dan deskripsi kategori untuk mengelompokkan aspirasi.
                </p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-pen-to-square me-1"></i>
                        Form Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                        @csrf
                        @if(isset($category))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-tag me-1 text-secondary"></i>
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $category->name ?? '') }}"
                                   placeholder="Contoh: Fasilitas, Akademik, Keuangan"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-align-left me-1 text-secondary"></i>
                                Deskripsi
                            </label>
                            <textarea name="description"
                                      rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Jelaskan deskripsi aspirasi yang cocok untuk kategori ini...">{{ old('description', $category->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">
                                Deskripsi akan ditampilkan ke mahasiswa saat memilih kategori.
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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
