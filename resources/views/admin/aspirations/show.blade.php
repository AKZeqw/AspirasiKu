@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="container py-4">
    <div class="row">
        {{-- Kolom kiri: detail + diskusi --}}
        <div class="col-md-8">
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    {{-- Header Aspirasi --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="mb-1">
                                <i class="fa-solid fa-lightbulb text-warning me-2"></i>
                                {{ $aspiration->title }}
                            </h3>
                            <p class="text-muted mb-0 small">
                                <i class="fa-solid fa-user me-1"></i>
                                @if($aspiration->is_anonymous) Anonymous @else {{ $aspiration->user->name }} ({{ $aspiration->user->nim }}) @endif
                                <span class="mx-2">•</span>
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
                        <h5 class="mb-2"><i class="fa-solid fa-align-left me-1"></i> Deskripsi</h5>
                        <p style="white-space: pre-line;">{{ $aspiration->description }}</p>
                    </div>

                    @if($aspiration->attachments->count() > 0)
                        <div class="mb-3">
                            <h5 class="mb-2"><i class="fa-solid fa-paperclip me-1"></i> Lampiran</h5>
                            <div class="list-group">
                                @foreach($aspiration->attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <span><i class="fa-regular fa-file-lines me-2"></i> {{ $attachment->file_name }}</span>
                                        <small class="text-muted">{{ number_format($attachment->file_size / 1024, 2) }} KB</small>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Form Update Status --}}
                    <div class="card bg-light border-0 mt-3">
                        <div class="card-body">
                            <h6 class="mb-2"><i class="fa-solid fa-arrows-rotate me-1 text-secondary"></i> Ubah Status</h6>
                            <form method="POST" action="{{ route('admin.aspirations.status', $aspiration) }}" class="row g-3 align-items-end" id="form-update-status">
                                @csrf @method('PUT')
                                <div class="col-md-8">
                                    <select name="status" class="form-select" required>
                                        <option value="submitted" {{ $aspiration->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                        <option value="under_review" {{ $aspiration->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                        <option value="in_progress" {{ $aspiration->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $aspiration->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="rejected" {{ $aspiration->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-circle-check me-1"></i> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Responses Section --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fa-solid fa-comments me-2 text-primary"></i>
                    <h5 class="mb-0">Diskusi & Tanggapan</h5>
                </div>
                <div class="card-body">
                    @forelse($aspiration->responses as $response)
                        <div class="card mb-3 {{ $response->sender_type === 'admin' ? 'border-primary' : 'border-secondary' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center">
                                        @if($response->sender_type === 'admin')
                                            <i class="fa-solid fa-user-shield text-primary me-2"></i>
                                            <strong>{{ $response->user->name }}</strong>
                                            <span class="badge bg-primary ms-2">ADMIN</span>
                                        @else
                                            <i class="fa-solid fa-user me-2"></i>
                                            <strong>{{ $aspiration->is_anonymous ? 'Anonymous' : $response->user->name }}</strong>
                                        @endif
                                        <small class="text-muted ms-2">• {{ $response->created_at->diffForHumans() }}</small>
                                    </div>

                                    {{-- DROPDOWN MENU EDIT/DELETE --}}
                                    {{-- Admin bisa edit punya sendiri, dan hapus punya siapa saja --}}
                                    @if(auth()->id() === $response->user_id || auth()->user()->isAdmin())
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if(auth()->id() === $response->user_id)
                                                    <li>
                                                        <button class="dropdown-item btn-edit-response" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editResponseModal"
                                                            data-message="{{ $response->message }}"
                                                            data-action="{{ route('admin.responses.update', $response->id) }}">
                                                            <i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Edit
                                                        </button>
                                                    </li>
                                                @endif
                                                <li>
                                                    <form action="{{ route('admin.responses.destroy', $response->id) }}" method="POST" class="delete-response-form">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fa-solid fa-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <p class="mb-2" style="white-space: pre-wrap;">{{ $response->message }}</p>

                                @if($response->attachments->count() > 0)
                                    <div class="mt-2">
                                        <small class="text-muted d-block mb-1"><i class="fa-solid fa-paperclip me-1"></i> Lampiran:</small>
                                        @foreach($response->attachments as $attachment)
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="badge bg-secondary text-decoration-none me-1 mb-1">
                                                <i class="fa-regular fa-file-lines me-1"></i> {{ $attachment->file_name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">Belum ada tanggapan.</p>
                    @endforelse

                    {{-- Form Tanggapan Admin --}}
                    <form method="POST" action="{{ route('admin.responses.store', $aspiration) }}" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-reply me-1"></i> Tanggapan Anda</label>
                            <textarea name="message" rows="4" class="form-control @error('message') is-invalid @enderror" placeholder="Berikan tanggapan resmi..." required></textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-file-circle-plus me-1"></i> Lampiran (Opsional)</label>
                            <input type="file" name="attachments[]" class="form-control" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane me-1"></i> Kirim Tanggapan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: info mahasiswa --}}
        <div class="col-md-4">
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fa-solid fa-user-graduate me-1 text-secondary"></i> Informasi Mahasiswa</h6>
                </div>
                <div class="card-body">
                    @if(!$aspiration->is_anonymous)
                        <table class="table table-sm mb-0">
                            <tr><td><strong>Nama:</strong></td><td>{{ $aspiration->user->name }}</td></tr>
                            <tr><td><strong>NIM:</strong></td><td>{{ $aspiration->user->nim }}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>{{ $aspiration->user->email }}</td></tr>
                        </table>
                    @else
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-user-secret fa-2x mb-2"></i>
                            <p class="mb-0">Aspirasi Anonim</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fa-solid fa-circle-info me-1 text-secondary"></i> Detail Aspirasi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td><span class="badge status-{{ $aspiration->status }}">{{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}</span></td>
                        </tr>
                        <tr><td><strong>Kategori:</strong></td><td>{{ $aspiration->category->name }}</td></tr>
                        <tr><td><strong>Dibuat:</strong></td><td>{{ $aspiration->created_at->format('d M Y, H:i') }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT RESPONSE --}}
<div class="modal fade" id="editResponseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Tanggapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditResponse" method="POST" action="">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editMessage" class="form-label">Pesan</label>
                        <textarea class="form-control" id="editMessage" name="message" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Logic Tombol Edit
        const editButtons = document.querySelectorAll('.btn-edit-response');
        const editForm = document.getElementById('formEditResponse');
        const editMessage = document.getElementById('editMessage');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const message = this.getAttribute('data-message');
                const action = this.getAttribute('data-action');
                
                editMessage.value = message;
                editForm.action = action;
            });
        });

        // 2. Konfirmasi Hapus Response
        document.querySelectorAll('.delete-response-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus tanggapan?',
                    text: "Tanggapan yang dihapus tidak bisa dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // 3. Konfirmasi Update Status (Yang sudah ada)
        document.getElementById('form-update-status')?.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Ubah status?',
                text: 'Perubahan status akan terlihat oleh mahasiswa.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Ya, simpan'
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });
    });
</script>
@endpush
@endsection