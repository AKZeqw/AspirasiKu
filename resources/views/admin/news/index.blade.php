@extends('layouts.app')

@section('title', 'Kelola Berita')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="mb-1">
                <i class="fa-solid fa-newspaper text-primary me-2"></i>
                Kelola Berita
            </h2>
            <p class="text-muted mb-0">Atur berita kampus, open recruitment, perlombaan, dan lainnya.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus me-1"></i> Tambah Berita
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Dipublikasikan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->title }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fa-solid fa-user-pen me-1"></i>
                                        {{ $item->author->name ?? 'Admin' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $item->type_label ?? ucfirst(str_replace('_', ' ', $item->type)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->published_at)
                                        <small>
                                            <i class="fa-regular fa-calendar-days me-1 text-muted"></i>
                                            {{ $item->published_at->format('d M Y, H:i') }}
                                        </small>
                                    @else
                                        <span class="text-muted small">Belum dipublikasikan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_published)
                                        <span class="badge bg-success-subtle text-success border border-success">
                                            <i class="fa-solid fa-circle-check me-1"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary">
                                            <i class="fa-regular fa-floppy-disk me-1"></i> Draft
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('news.show', $item->id) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.news.edit', $item) }}"
                                    class="btn btn-sm btn-outline-warning text-warning border-warning me-1">
                                        <i class="fa-solid fa-pen me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item) }}"
                                        method="POST"
                                        class="d-inline delete-news-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada berita. Tambahkan berita pertama sekarang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($news, 'links'))
                <div class="mt-3 d-flex justify-content-center">
                    {{ $news->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-news-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus berita?',
                    text: 'Berita yang dihapus tidak dapat dikembalikan.',
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
