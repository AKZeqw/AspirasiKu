@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3>{{ $aspiration->title }}</h3>
                            <p class="text-muted mb-0">
                                <i class="bi bi-tag"></i> {{ $aspiration->category->name }}
                                <span class="mx-2">•</span>
                                <i class="bi bi-calendar"></i> {{ $aspiration->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <span class="badge status-{{ $aspiration->status }}">
                            {{ ucfirst(str_replace('_', ' ', $aspiration->status)) }}
                        </span>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h5>Deskripsi</h5>
                        <p style="white-space: pre-line;">{{ $aspiration->description }}</p>
                    </div>

                    @if($aspiration->attachments->count() > 0)
                        <div class="mb-3">
                            <h5>Lampiran</h5>
                            <div class="list-group">
                                @foreach($aspiration->attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="list-group-item list-group-item-action">
                                        <i class="bi bi-file-earmark"></i> {{ $attachment->file_name }}
                                        <small class="text-muted">({{ number_format($attachment->file_size / 1024, 2) }} KB)</small>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(in_array($aspiration->status, ['draft', 'submitted']))
                        <div class="d-flex gap-2">
                            <a href="{{ route('mahasiswa.aspirations.edit', $aspiration) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('mahasiswa.aspirations.destroy', $aspiration) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus aspirasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Responses -->
            <div class="card">
                <div class="card-header">
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
                                                <i class="bi bi-shield-check text-primary"></i> {{ $response->user->name }} 
                                                <span class="badge bg-primary">{{ strtoupper($response->user->role) }}</span>
                                            @else
                                                <i class="bi bi-person"></i> Anda
                                            @endif
                                        </strong>
                                        <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-2">{{ $response->message }}</p>

                                    @if($response->attachments->count() > 0)
                                        <div class="mt-2">
                                            <small class="text-muted">Lampiran:</small>
                                            @foreach($response->attachments as $attachment)
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="badge bg-secondary me-1">
                                                    <i class="bi bi-paperclip"></i> {{ $attachment->file_name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($response->sender_type === 'mahasiswa')
                                        <form action="{{ route('mahasiswa.responses.destroy', $response) }}" method="POST" class="mt-2"
                                              onsubmit="return confirm('Yakin ingin menghapus balasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Hapus
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
                        <form method="POST" action="{{ route('mahasiswa.responses.store', $aspiration) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Balasan Anda</label>
                                <textarea name="message" rows="3" class="form-control @error('message') is-invalid @enderror" required></textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lampiran (Opsional)</label>
                                <input type="file" name="attachments[]" class="form-control" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Kirim Balasan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Informasi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
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
@endsection
