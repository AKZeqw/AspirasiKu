@extends('layouts.app')

@section('title', isset($aspiration) ? 'Edit Aspirasi' : 'Buat Aspirasi')

@section('content')
<style>
    #is_anonymous.form-check-input {
        width: 1.1rem;
        height: 1.1rem;
        border: 2px solid #444 !important;
        background-color: #fff !important;
    }

    #is_anonymous.form-check-input:checked {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }
</style>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Header --}}
            <div class="mb-3">
                <h2 class="mb-1">
                    <i class="fa-solid fa-comment-dots text-primary me-2"></i>
                    {{ isset($aspiration) ? 'Edit Aspirasi' : 'Buat Aspirasi Baru' }}
                </h2>
                <p class="text-muted mb-0">
                    Tulis aspirasi dengan jelas agar mudah dipahami dan ditindaklanjuti.
                </p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-pen-to-square me-1"></i>
                        Form Aspirasi
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($aspiration) ? route('mahasiswa.aspirations.update', $aspiration) : route('mahasiswa.aspirations.store') }}"
                          enctype="multipart/form-data"
                          id="form-aspirasi">
                        @csrf
                        @if(isset($aspiration))
                            @method('PUT')
                        @endif

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-heading me-1 text-secondary"></i>
                                Judul Aspirasi <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $aspiration->title ?? '') }}"
                                   placeholder="Contoh: Perbaikan fasilitas ruang belajar di Gedung A"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-tags me-1 text-secondary"></i>
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="right"
                                            title="{{ $category->description }}"
                                            {{ old('category_id', $aspiration->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                Arahkan kursor ke nama kategori untuk melihat deskripsi lengkap.
                            </small>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-align-left me-1 text-secondary"></i>
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea name="description"
                                      rows="6"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Jelaskan kronologi, lokasi, pihak terkait, dan harapan solusi..."
                                      required>{{ old('description', $aspiration->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lampiran --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-file-circle-plus me-1 text-secondary"></i>
                                Lampiran (Opsional)
                            </label>
                            <input type="file"
                                   name="attachments[]"
                                   class="form-control @error('attachments.*') is-invalid @enderror"
                                   multiple>
                            <small class="text-muted d-block">
                                Format: JPG, PNG, PDF, DOC, XLS, ZIP. Maksimal 10MB per file.
                            </small>
                            @error('attachments.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lampiran saat ini (edit) --}}
                        @if(isset($aspiration) && $aspiration->attachments->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fa-regular fa-file-lines me-1"></i>
                                    Lampiran Saat Ini
                                </label>
                                <div class="list-group">
                                    @foreach($aspiration->attachments as $attachment)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="fa-regular fa-file me-1"></i>
                                                {{ $attachment->file_name }}
                                            </span>
                                            <small class="text-muted">
                                                {{ number_format($attachment->file_size / 1024, 2) }} KB
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Anonim --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox"
                                   name="is_anonymous"
                                   class="form-check-input"
                                   id="is_anonymous"
                                   {{ old('is_anonymous', $aspiration->is_anonymous ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_anonymous">
                                Kirim sebagai Anonim
                            </label>
                            <small class="text-muted d-block">
                                Identitasmu tidak akan ditampilkan di halaman publik jika memilih anonim.
                            </small>
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
                                    value="submit"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane me-1"></i> Submit Aspirasi
                            </button>
                            <a href="{{ route('mahasiswa.aspirations.index') }}"
                               class="btn btn-outline-secondary">
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
