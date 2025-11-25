@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="mb-1">
                <i class="fa-solid fa-list-check text-primary me-2"></i>
                Kelola Kategori
            </h2>
            <p class="text-muted mb-0">Atur kategori agar aspirasi lebih terstruktur.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus me-1"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Aspirasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr id="category-row-{{ $category->id }}">
                                <td>
                                    <strong>
                                        <i class="fa-solid fa-tag me-1 text-secondary"></i>
                                        {{ $category->name }}
                                    </strong>
                                </td>
                                <td>{{ Str::limit($category->description, 70) }}</td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info">
                                        <i class="fa-solid fa-comments me-1"></i>
                                        {{ $category->aspirations_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-sm btn-outline-warning border-warning me-1">
                                        <i class="fa-solid fa-pen me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                          method="POST"
                                          class="d-inline delete-category-form"
                                          data-id="{{ $category->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada kategori. Tambahkan kategori baru terlebih dahulu.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Optional: konfirmasi SweetAlert2 untuk hapus kategori --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-category-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Hapus kategori?',
                    text: 'Kategori yang dihapus dapat mempengaruhi pengelompokan aspirasi.',
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
