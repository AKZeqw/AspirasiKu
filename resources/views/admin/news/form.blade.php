@extends('layouts.app')

@section('title', isset($news) ? 'Edit Berita' : 'Tambah Berita')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Header --}}
            <div class="mb-3">
                <h2 class="mb-1">
                    <i class="fa-solid fa-newspaper text-primary me-2"></i>
                    {{ isset($news) ? 'Edit Berita' : 'Tambah Berita' }}
                </h2>
                <p class="text-muted mb-0">
                    Kelola berita kampus, open recruitment, perlombaan, prestasi, dan lainnya.
                </p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-pen-to-square me-1"></i>
                        Form Berita
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($news) ? route('admin.news.update', $news) : route('admin.news.store') }}"
                          enctype="multipart/form-data"
                          id="form-berita">
                        @csrf
                        @if(isset($news))
                            @method('PUT')
                        @endif

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-heading me-1 text-secondary"></i>
                                Judul Berita <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $news->title ?? '') }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tipe --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-layer-group me-1 text-secondary"></i>
                                Tipe Berita <span class="text-danger">*</span>
                            </label>
                            <select name="news_type_id"
                                    class="form-select @error('news_type_id') is-invalid @enderror"
                                    required>
                                <option value="">Pilih tipe berita</option>
                                @foreach($newsTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('news_type_id', $news->news_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('news_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Excerpt --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-align-left me-1 text-secondary"></i>
                                Ringkasan Singkat (opsional)
                            </label>
                            <textarea name="excerpt"
                                      rows="3"
                                      class="form-control @error('excerpt') is-invalid @enderror"
                                      placeholder="Ringkasan pendek yang akan ditampilkan di kartu berita.">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konten --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-file-lines me-1 text-secondary"></i>
                                Konten Berita <span class="text-danger">*</span>
                            </label>
                            <textarea name="content"
                                      rows="8"
                                      class="form-control @error('content') is-invalid @enderror"
                                      required>{{ old('content', $news->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cover image --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-image me-1 text-secondary"></i>
                                Gambar Cover (opsional)
                            </label>
                            <input type="file"
                                   name="cover_image"
                                   class="form-control @error('cover_image') is-invalid @enderror">
                            <small class="text-muted d-block">
                                Format: JPG, PNG. Maksimal 20MB.
                            </small>
                            @error('cover_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            @if(isset($news) && $news->cover_image)
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Cover saat ini:</small>
                                    <img src="{{ asset('storage/'.$news->cover_image) }}"
                                         alt="Cover"
                                         class="img-fluid rounded"
                                         style="max-height: 150px;">
                                </div>
                            @endif
                        </div>

                        {{-- Tombol aksi --}}
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit"
                                    name="action"
                                    value="draft"
                                    class="btn btn-outline-secondary">
                                <i class="fa-regular fa-floppy-disk me-1"></i> Simpan Draft
                            </button>

                            <button type="submit"
                                    name="action"
                                    value="publish"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane me-1"></i> Publikasikan
                            </button>

                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
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
