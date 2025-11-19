@extends('layouts.app')

@section('title', isset($aspiration) ? 'Edit Aspirasi' : 'Buat Aspirasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ isset($aspiration) ? 'Edit Aspirasi' : 'Buat Aspirasi Baru' }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($aspiration) ? route('mahasiswa.aspirations.update', $aspiration) : route('mahasiswa.aspirations.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($aspiration))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Judul Aspirasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $aspiration->title ?? '') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
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
                                <i class="bi bi-info-circle"></i> Hover pada kategori untuk melihat deskripsi lengkap
                            </small>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $aspiration->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lampiran (Opsional)</label>
                            <input type="file" name="attachments[]" class="form-control @error('attachments.*') is-invalid @enderror" multiple>
                            <small class="text-muted">Format: JPG, PNG, PDF, DOC, XLS, ZIP. Max 10MB per file</small>
                            @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(isset($aspiration) && $aspiration->attachments->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">Lampiran Saat Ini</label>
                                <div class="list-group">
                                    @foreach($aspiration->attachments as $attachment)
                                        <div class="list-group-item">
                                            <i class="bi bi-file-earmark"></i> {{ $attachment->file_name }}
                                            <small class="text-muted">({{ number_format($attachment->file_size / 1024, 2) }} KB)</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_anonymous" class="form-check-input" id="is_anonymous"
                                {{ old('is_anonymous', $aspiration->is_anonymous ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_anonymous">
                                Kirim sebagai Anonim
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="action" value="draft" class="btn btn-secondary">
                                <i class="bi bi-save"></i> Simpan Draft
                            </button>
                            <button type="submit" name="action" value="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Submit Aspirasi
                            </button>
                            <a href="{{ route('mahasiswa.aspirations.index') }}" class="btn btn-outline-secondary">
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
