<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AspirasiKu - Sistem Aspirasi Mahasiswa UNEJ')</title>
    
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-soft: #e0edff;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --dark-color: #0f172a;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef6ff;
            color: #0f172a;
        }

        .navbar {
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            letter-spacing: 0.02em;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #0f172a;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            border-radius: 0.75rem;
        }

        .badge {
            padding: 0.35rem 0.7rem;
            font-weight: 500;
            border-radius: 999px;
        }

        .status-draft { background-color: #6b7280; }
        .status-submitted { background-color: #3b82f6; }
        .status-under_review { background-color: #f59e0b; }
        .status-in_progress { background-color: #8b5cf6; }
        .status-completed { background-color: #10b981; }
        .status-rejected { background-color: #ef4444; }

        main {
            padding-top: 1.5rem;
            padding-bottom: 2rem;
        }

        footer {
            margin-top: auto;
            background: radial-gradient(circle at top left, #1d4ed8, #020617);
            color: white;
            padding: 1.75rem 0;
            font-size: 0.9rem;
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="AspirasiKu Logo" height="42" class="me-2">
                <span>AspirasiKu</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-gauge-high me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.aspirations.index') }}">
                                    <i class="fa-solid fa-inbox me-1"></i> Aspirasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                                    <i class="fa-solid fa-tags me-1"></i> Kategori
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.news.index') }}">
                                    <i class="fa-solid fa-newspaper me-1"></i> Berita
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.news-types.index') }}">
                                    <i class="fa-solid fa-layer-group me-1"></i> Tipe Berita
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">
                                    <i class="fa-solid fa-house-chimney me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('mahasiswa.aspirations.index') }}">
                                    <i class="fa-solid fa-comment-dots me-1"></i> Aspirasi Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('public.aspirations') }}">
                                    <i class="fa-solid fa-users-viewfinder me-1"></i> Aspirasi Publik
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('news.index') }}">
                                    <i class="fa-solid fa-newspaper me-1"></i> Berita
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user fa-lg me-2"></i>
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                            <i class="fa-solid fa-user-pen me-2"></i> Profil
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mahasiswa.profile.edit') }}">
                                            <i class="fa-solid fa-user-pen me-2"></i> Profil
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('public.aspirations') }}">
                                <i class="fa-solid fa-comments me-1"></i> Aspirasi Publik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('news.index') }}">
                                <i class="fa-solid fa-newspaper me-1"></i> Berita
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link btn btn-primary text-white px-3" href="{{ route('register') }}">
                                <i class="fa-solid fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <div class="container text-center">
            <p class="mb-1">
                &copy; 2025 AspirasiKu - Universitas Jember.
            </p>
            <p class="mb-0 text-white-50">
                Dibangun untuk menyalurkan suara mahasiswa secara terbuka dan bertanggung jawab.
            </p>
        </div>
    </footer>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- SweetAlert2 flash message (toast) --}}
    <script>
        @if(session('success'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: "{{ session('success') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                toast: true,
                icon: 'error',
                title: "{{ session('error') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
