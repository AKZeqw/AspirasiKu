@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="container py-4">
    <div class="row">
        {{-- Kolom kiri: detail & diskusi --}}
        <div class="col-md-8">
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="mb-1">
                                <i class="fa-solid fa-lightbulb text-warning me-2"></i>
                                {{ $aspiration->title }}
                            </h3>
                            <p class="text-muted mb-0 small">
                                <i class="fa-solid fa-tag me-1"></i> {{ $aspiration->category->name }}
                                <span class="mx-2">•</span>
                                <i class="fa-regular fa-calendar-days me-1"></i>
                                {{ $aspiration->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <span class="badge status-{{ $aspiration->status }}">
                            {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                        </span>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h5 class="mb-2">
                            <i class="fa-solid fa-align-left me-1"></i> Deskripsi
                        </h5>
                        <p style="white-space: pre-line;">{{ $aspiration->description }}</p>
                    </div>

                    @if($aspiration->attachments->count() > 0)
                        <div class="mb-3">
                            <h5 class="mb-2">
                                <i class="fa-solid fa-paperclip me-1"></i> Lampiran
                            </h5>
                            <div class="list-group">
                                @foreach($aspiration->attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                       target="_blank"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-regular fa-file-lines me-2"></i>
                                            {{ $attachment->file_name }}
                                        </span>
                                        <small class="text-muted">
                                            {{ number_format($attachment->file_size / 1024, 2) }} KB
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(in_array($aspiration->status, ['draft', 'submitted']))
                        <div class="d-flex gap-2">
                            <a href="{{ route('mahasiswa.aspirations.edit', $aspiration) }}"
                               class="btn btn-warning text-white">
                                <i class="fa-solid fa-pen me-1"></i> Edit
                            </a>
                            <form action="{{ route('mahasiswa.aspirations.destroy', $aspiration) }}"
                                  method="POST"
                                  id="form-delete-aspiration">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Responses --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fa-solid fa-comments me-2 text-primary"></i>
                    <h5 class="mb-0">Diskusi & Tanggapan</h5>
                </div>
                <div class="card-body">
                    @if($aspiration->responses->count() > 0)
                        @foreach($aspiration->responses as $response)
                            <div class="card mb-3 {{ $response->sender_type === 'admin' ? 'border-primary' : '' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>
                                            @if($response->sender_type === 'admin')
                                                <i class="fa-solid fa-user-shield text-primary me-1"></i>
                                                {{ $response->user->name }}
                                                <span class="badge bg-primary ms-1">
                                                    {{ strtoupper($response->user->role) }}
                                                </span>
                                            @else
                                                <i class="fa-solid fa-user me-1"></i> Anda
                                            @endif
                                        </strong>
                                        <small class="text-muted">
                                            <i class="fa-regular fa-clock me-1"></i>
                                            {{ $response->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <p class="mb-2">{{ $response->message }}</p>

                                    @if($response->attachments->count() > 0)
                                        <div class="mt-2">
                                            <small class="text-muted d-block mb-1">
                                                <i class="fa-solid fa-paperclip me-1"></i> Lampiran:
                                            </small>
                                            @foreach($response->attachments as $attachment)
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                   target="_blank"
                                                   class="badge bg-secondary text-decoration-none me-1 mb-1">
                                                    <i class="fa-regular fa-file-lines me-1"></i>
                                                    {{ $attachment->file_name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($response->sender_type === 'mahasiswa')
                                        <form action="{{ route('mahasiswa.responses.destroy', $response) }}"
                                              method="POST"
                                              class="mt-2 delete-response-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">Belum ada tanggapan</p>
                    @endif

                    @if(!in_array($aspiration->status, ['draft', 'rejected', 'completed']))
                        <form method="POST"
                              action="{{ route('mahasiswa.responses.store', $aspiration) }}"
                              enctype="multipart/form-data"
                              class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fa-solid fa-reply me-1"></i> Balasan Anda
                                </label>
                                <textarea name="message"
                                          rows="3"
                                          class="form-control @error('message') is-invalid @enderror"
                                          required></textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fa-solid fa-file-circle-plus me-1"></i>
                                    Lampiran (Opsional)
                                </label>
                                <input type="file" name="attachments[]" class="form-control" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane me-1"></i> Kirim Balasan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom kanan: info ringkas --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-circle-info me-1 text-secondary"></i>
                        Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge status-{{ $aspiration->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Kategori:</strong></td>
                            <td>{{ $aspiration->category->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $aspiration->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $aspiration->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mode:</strong></td>
                            <td>{{ $aspiration->is_anonymous ? 'Anonim' : 'Publik' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Optional: konfirmasi SweetAlert2 untuk hapus aspirasi & balasan --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hapus aspirasi
        const deleteAspForm = document.getElementById('form-delete-aspiration');
        if (deleteAspForm) {
            deleteAspForm.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus aspirasi?',
                    text: 'Aspirasi yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteAspForm.submit();
                    }
                });
            });
        }

        // Hapus balasan mahasiswa
        document.querySelectorAll('.delete-response-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus balasan?',
                    text: 'Balasan yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
