# AspirasiKu - Platform Aspirasi Mahasiswa UNEJ

Sistem manajemen aspirasi online yang memungkinkan mahasiswa Universitas Jember untuk menyampaikan aspirasi, keluhan, dan saran kepada pihak universitas secara transparan dan terstruktur.

## 🎯 Tentang Aplikasi

AspirasiKu adalah platform berbasis web yang dibangun dengan **Laravel 12 dan Bootstrap 5**. Platform ini memfasilitasi komunikasi dua arah antara mahasiswa dan administrator kampus melalui sistem aspirasi yang terorganisir dengan baik.

## ✨ Fitur-Fitur Utama

### 1. **Sistem Autentikasi & Autorisasi**
- ✅ Registrasi akun mahasiswa dengan validasi NIM
- ✅ Login standar dengan email dan password
- ✅ Integrasi Google OAuth 2.0 untuk login sosial
- ✅ Sistem role-based access control (Mahasiswa, Admin)
- ✅ Logout dan session management yang aman
- ✅ Validasi email domain @mail.unej.ac.id

### 2. **Manajemen Aspirasi Mahasiswa**
- ✏️ **CRUD Aspirasi**: Buat, baca, ubah, dan hapus aspirasi
- 📝 **Input Lengkap**: Judul, deskripsi, kategori, dan lampiran file
- 🔐 **Mode Anonim**: Pilihan untuk mengirim aspirasi secara anonim
- 📁 **Upload Lampiran**: Dukungan untuk mengunggah file bukti atau dokumen pendukung
- 🏷️ **Kategorisasi**: Organisir aspirasi berdasarkan kategori yang sudah ditentukan
- 📊 **Status Tracking**: Monitor status aspirasi (draft, submitted, under_review, in_progress, completed, rejected)
- 🎯 **Dashboard Pribadi**: Lihat daftar aspirasi terbaru di halaman dashboard
- 📈 **Statistik Aspirasi**: Lihat ringkasan status aspirasi di dashboard

### 3. **Sistem Response & Komunikasi**
- 💬 **Response Dua Arah**: Mahasiswa dan admin dapat memberikan response
- 📝 **Diskusi Terstruktur**: Thread komunikasi terorganisir untuk setiap aspirasi
- 📎 **Lampiran Response**: Setiap response dapat dilengkapi dengan file pendukung
- 🗑️ **Kelola Response**: Hapus response yang telah dibuat
- 👤 **Identifikasi Pengirim**: Ketahui siapa yang memberikan response

### 4. **Dashboard Mahasiswa**
- 📊 Overview aspirasi personal dengan statistik
- 📈 Status aspirasi real-time
- 🔔 Notifikasi response dari admin
- ⚙️ Manajemen profil pribadi
- 🔑 Ubah password dengan konfirmasi
- 👤 Edit informasi profil (nama, email)
- 📋 Riwayat aspirasi lengkap

### 5. **Dashboard Admin**
- 📋 **Kelola Aspirasi**: Lihat semua aspirasi dari seluruh mahasiswa
- 👁️ **Detail Aspirasi**: Review lengkap setiap aspirasi dengan metadata
- ✅ **Update Status**: Ubah status aspirasi (ditinjau, diproses, selesai, ditolak)
- 📤 **Berikan Response**: Reply langsung ke aspirasi mahasiswa
- 🏷️ **Kelola Kategori**: CRUD kategori aspirasi (Tambah, Edit, Hapus)
- 📊 **Dashboard Analytics**: Statistik aspirasi (total, submitted, in_progress, completed, rejected)
- 👤 **Profil Admin**: Kelola profil dan keamanan akun
- 🔍 **Filter & Search**: Cari aspirasi berdasarkan berbagai kriteria

### 6. **Fitur Public/Transparansi**
- 👁️ **Public Aspirations**: Lihat aspirasi yang sudah completed tanpa login
- 🔍 **Pencarian & Filter**: Temukan aspirasi berdasarkan kategori
- 📱 **Interface Responsif**: Akses dari desktop, tablet, atau mobile
- 🗞️ **Berita & Pengumuman**: Fitur berita dan tipe berita untuk informasi tambahan

### 7. **Manajemen Kategori**
- ➕ Tambah kategori aspirasi baru
- ✏️ Edit nama dan deskripsi kategori
- 🗑️ Hapus kategori yang tidak digunakan
- 📊 Statistik aspirasi per kategori

### 8. **Manajemen File & Lampiran**
- 📎 Upload multiple attachments
- 📁 Polymorphic relationship untuk aspirasi dan response
- 🔍 Track file metadata (nama, tipe, ukuran)
- 💾 Sistem penyimpanan terstruktur di storage/app

### 9. **Soft Delete & Data Recovery**
- 🔄 Aspirasi yang dihapus dapat dipulihkan
- 🛡️ Data tidak benar-benar hilang dari database
- 📜 Audit trail untuk compliance

### 10. **Fitur Berita & Pengumuman**
- 📰 Manajemen berita kampus
- 📑 Tipe berita yang terorganisir
- 🔔 Pengumuman penting untuk mahasiswa

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12
- **Authentication**: Laravel Auth + Socialite (Google OAuth)
- **Database**: MySQL/SQLite
- **ORM**: Eloquent

### Frontend
- **CSS Framework**: Bootstrap 5.3
- **Build Tool**: Vite 7
- **CSS Preprocessor**: Tailwind CSS 4.0 (@tailwindcss/vite)
- **Icons**: Font Awesome 6.5
- **JS Framework**: Vanilla JavaScript + Bootstrap Bundle

### Notifications & Alerts
- **SweetAlert2**: Modal alerts dan toast notifications
- **Bootstrap Toast**: Flash messages

### Dependencies
- **Laravel Socialite**: ^5.23 (Google OAuth)
- **Laravel Tinker**: ^2.10.1 (REPL)
- **PHPUnit**: ^11.5.3 (Testing)
- **Faker**: ^1.23 (Test Data)
- **Concurrently**: ^9.0.1 (Development)

## 📦 Struktur Database

### Tabel Utama

#### `users`
```
- id (primary key)
- name (nama lengkap)
- email (unique, domain @mail.unej.ac.id)
- nim (student ID, unique)
- password (hashed)
- role (mahasiswa, admin)
- google_id (optional, untuk OAuth)
- email_verified_at
- remember_token
- created_at, updated_at
```

#### `aspirations`
```
- id (primary key)
- user_id (foreign key to users)
- category_id (foreign key to categories)
- title (judul aspirasi)
- description (deskripsi lengkap)
- is_anonymous (boolean, default: false)
- status (draft, submitted, under_review, in_progress, completed, rejected)
- deleted_at (soft delete timestamp)
- created_at, updated_at
```

#### `responses`
```
- id (primary key)
- aspiration_id (foreign key to aspirations)
- user_id (foreign key to users)
- message (isi balasan)
- sender_type (mahasiswa, admin)
- created_at, updated_at
```

#### `categories`
```
- id (primary key)
- name (nama kategori)
- description (deskripsi kategori)
- created_at, updated_at
```

#### `attachments` (Polymorphic)
```
- id (primary key)
- attachable_id (ID dari model yang direfer)
- attachable_type (Aspiration atau Response)
- file_name (nama file)
- file_path (path ke file)
- file_type (tipe file: pdf, doc, jpg, dll)
- file_size (ukuran file dalam bytes)
- created_at, updated_at
```

#### `news` & `news_types`
```
news:
- id, title, content, type_id, created_at, updated_at

news_types:
- id, name, created_at, updated_at
```

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 16+
- npm atau yarn
- MySQL 8.0+ atau SQLite

### Steps

1. **Clone repository**
```bash
git clone <repository-url>
cd AspirasiKu
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database di `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aspirasiKu
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrasi database**
```bash
php artisan migrate
php artisan db:seed
```

6. **Setup Google OAuth** (optional)
- Daftar di [Google Cloud Console](https://console.cloud.google.com/)
- Buat OAuth 2.0 credentials
- Tambahkan di `.env`:
```env
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_CLIENT_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

7. **Build assets**
```bash
npm run build
```

8. **Jalankan server**
```bash
php artisan serve
```

Aplikasi akan tersedia di `http://localhost:8000`

## 📝 Development

### Menjalankan development environment
```bash
composer run dev
```

Ini akan menjalankan secara concurrent:
- PHP development server
- Queue listener
- Log viewer (Laravel Pail)
- Vite dev server (untuk hot reload)

### Development commands
```bash
# Database migration & seeding
php artisan migrate
php artisan db:seed

# Clear cache
php artisan cache:clear
php artisan config:clear

# Testing
composer run test

# Code formatting
php artisan pint
```

## 🧪 Testing

```bash
composer run test
```

Atau run specific test file:
```bash
php artisan test tests/Feature/ExampleTest.php
```

## 📁 Struktur Project

```
AspirasiKu/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Authentication controllers
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── GoogleAuthController.php
│   │   │   ├── Mahasiswa/               # Student controllers
│   │   │   │   ├── AspirationController.php
│   │   │   │   ├── ResponseController.php
│   │   │   │   └── ProfileController.php
│   │   │   ├── Admin/                   # Admin controllers
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── AdminAspirationController.php
│   │   │   │   ├── AdminResponseController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── ProfileController.php
│   │   │   │   ├── NewsController.php
│   │   │   │   └── NewsTypeController.php
│   │   │   └── PublicAspirationController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Aspiration.php
│   │   ├── Response.php
│   │   ├── Category.php
│   │   ├── Attachment.php
│   │   ├── News.php
│   │   └── NewsType.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   ├── AdminSeeder.php
│   │   ├── CategorySeeder.php
│   │   └── DatabaseSeeder.php
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php
│   │   ├── landing.blade.php
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── aspirations/
│   │   │   ├── categories/
│   │   │   ├── news/
│   │   │   ├── news_types/
│   │   │   └── profile/
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── mahasiswa/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── aspirations/
│   │   │   └── profile/
│   │   ├── public/
│   │   │   └── aspirations/
│   │   ├── news/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   ├── components/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   ├── css/
│   │   └── app.css (Tailwind CSS config)
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── lang/
│       └── id/
│           └── validation.php (Indonesian translations)
├── routes/
│   ├── web.php                  # Web routes
│   └── console.php
├── storage/
│   ├── app/
│   │   ├── private/
│   │   └── public/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── config/
├── public/
│   ├── assets/
│   │   └── images/
│   ├── storage (symlink ke storage/app/public)
│   └── index.php
├── bootstrap/
├── vite.config.js
├── tailwind.config.js (jika ada)
├── package.json
├── composer.json
└── vendor/
```

## 🔐 Route Groups

### Public Routes
- `GET /` - Redirect ke login
- `GET /public-aspirations` - Lihat aspirasi yang published
- `GET /public-aspirations/{aspiration}` - Detail aspirasi publik
- `GET /news` - Lihat berita
- `GET /news/{id}` - Detail berita
- `GET /register` - Form registrasi
- `GET /login` - Form login
- `GET /auth/google` - Google OAuth login
- `GET /auth/google/callback` - Google OAuth callback

### Mahasiswa Routes (`/mahasiswa`)
- `GET /dashboard` - Dashboard personal
- `GET /aspirations` - List aspirasi user
- `POST /aspirations` - Buat aspirasi baru
- `GET /aspirations/{id}` - Detail aspirasi
- `PUT /aspirations/{id}` - Update aspirasi
- `DELETE /aspirations/{id}` - Hapus aspirasi
- `POST /aspirations/{id}/responses` - Buat response
- `DELETE /responses/{id}` - Hapus response
- `GET /profile` - Edit profil
- `PUT /profile` - Update profil
- `PUT /profile/password` - Ubah password

### Admin Routes (`/admin`)
- `GET /dashboard` - Admin dashboard dengan statistik
- `GET /aspirations` - List semua aspirasi
- `GET /aspirations/{id}` - Detail aspirasi
- `PUT /aspirations/{id}/status` - Update status aspirasi
- `POST /aspirations/{id}/responses` - Buat response ke aspirasi
- `GET /categories` - List kategori
- `POST /categories` - Buat kategori baru
- `PUT /categories/{id}` - Update kategori
- `DELETE /categories/{id}` - Hapus kategori
- `GET /news` - List berita
- `POST /news` - Buat berita baru
- `PUT /news/{id}` - Update berita
- `DELETE /news/{id}` - Hapus berita
- `GET /news-types` - List tipe berita
- `POST /news-types` - Buat tipe berita
- `PUT /news-types/{id}` - Update tipe berita
- `DELETE /news-types/{id}` - Hapus tipe berita
- `GET /profile` - Edit profil admin
- `PUT /profile` - Update profil
- `PUT /profile/password` - Ubah password

## 👥 Role & Izin

| Role | Deskripsi | Izin |
|------|-----------|------|
| **mahasiswa** | Mahasiswa | Membuat aspirasi, memberi balasan, melihat aspirasi publik, mengubah profil |
| **admin** | Administrator | Mengelola semua aspirasi, memberi balasan, mengelola kategori, berita, dashboard analytics |

## 📚 API Endpoints

### Aspirations
- `GET /mahasiswa/aspirations` - List aspirasi user
- `POST /mahasiswa/aspirations` - Buat aspirasi
- `GET /mahasiswa/aspirations/{id}` - Detail aspirasi
- `PUT /mahasiswa/aspirations/{id}` - Update aspirasi
- `DELETE /mahasiswa/aspirations/{id}` - Hapus aspirasi

### Admin Aspirations
- `GET /admin/aspirations` - List semua aspirasi
- `GET /admin/aspirations/{id}` - Detail aspirasi
- `PUT /admin/aspirations/{id}/status` - Update status

### Responses
- `POST /mahasiswa/aspirations/{id}/responses` - Add response mahasiswa
- `DELETE /mahasiswa/responses/{id}` - Delete response
- `POST /admin/aspirations/{id}/responses` - Admin response

### Categories
- `GET /admin/categories` - List kategori
- `POST /admin/categories` - Create kategori
- `PUT /admin/categories/{id}` - Update kategori
- `DELETE /admin/categories/{id}` - Delete kategori

### News
- `GET /news` - List berita publik
- `GET /news/{id}` - Detail berita
- `GET /admin/news` - List berita (admin)
- `POST /admin/news` - Create berita
- `PUT /admin/news/{id}` - Update berita
- `DELETE /admin/news/{id}` - Delete berita

## 🎨 UI Design

### Design Framework
- **CSS Framework**: Bootstrap 5.3 (Primary)
- **Tailwind CSS**: 4.0 (@tailwindcss/vite untuk build)
- **Icons**: Font Awesome 6.5 (comprehensive icon library)
- **Animations**: CSS transitions dan Font Awesome animations

### Component Library
- Navigation bar dengan responsive menu
- Sidebar (untuk admin)
- Modal dialogs dengan SweetAlert2
- Form components dengan validation styling
- Card layouts dengan gradients
- Table displays dengan sorting/filtering
- Alert messages (toast dan modal)
- Status badges dengan color coding
- Dashboard cards dengan statistik

### Color Scheme
- **Primary**: #2563eb (Blue)
- **Primary Soft**: #e0edff
- **Secondary**: #64748b (Slate)
- **Success**: #10b981 (Green)
- **Danger**: #ef4444 (Red)
- **Warning**: #f59e0b (Amber)
- **Dark**: #0f172a
- **Light Background**: #eef6ff

### Status Color Badges
- **Draft**: #6b7280 (Gray)
- **Submitted**: #3b82f6 (Blue)
- **Under Review**: #f59e0b (Amber)
- **In Progress**: #8b5cf6 (Purple)
- **Completed**: #10b981 (Green)
- **Rejected**: #ef4444 (Red)

## 🔒 Security Features

- ✅ CSRF protection (Laravel middleware)
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Password hashing (bcrypt)
- ✅ Role-based access control (gates & policies)
- ✅ Soft deletes (data retention)
- ✅ Secure file upload handling
- ✅ Session management
- ✅ HTTPS ready (in production)
- ✅ Email domain validation (@mail.unej.ac.id)

## 📧 Seeder & Factory

### AdminSeeder
Membuat akun admin default dengan credentials untuk testing

### CategorySeeder  
Populate kategori aspirasi dasar (default categories)

### UserFactory
Generate user dummy untuk testing dan development

## 📝 Localization

- **Language**: Indonesian (Bahasa Indonesia)
- **Locale**: `id`
- **Validation Messages**: Translated ke Indonesian
- **Date Format**: Localized untuk Indonesia

## 🤝 Kontribusi

1. Buat branch baru: `git checkout -b feature/AmazingFeature`
2. Commit changes: `git commit -m 'Add some AmazingFeature'`
3. Push ke branch: `git push origin feature/AmazingFeature`
4. Buka Pull Request

## 📄 Lisensi

MIT License - Lihat file LICENSE untuk detail

## 👨‍💻 Pengembang

Dikembangkan oleh tim AspirasiKu - Universitas Jember

## 📞 Support & Contact

Untuk pertanyaan atau laporan bug, silakan:
- Buat issue di repository ini
- Hubungi tim pengembang

---

**Status**: Active Development  
**Terakhir diupdate**: November 2025  
**Laravel Version**: 12  
**PHP Version**: 8.2+
