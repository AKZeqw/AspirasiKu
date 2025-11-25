# AspirasiKu - Platform Aspirasi Mahasiswa

Sistem manajemen aspirasi online yang memungkinkan mahasiswa untuk menyampaikan aspirasi, keluhan, dan saran kepada pihak universitas secara transparan dan terstruktur.

## 🎯 Tentang Aplikasi

AspirasiKu adalah platform berbasis web yang dibangun dengan Laravel 12 dan Tailwind CSS. Platform ini memfasilitasi komunikasi dua arah antara mahasiswa dan berbagai unit di kampus seperti Tata Usaha (TU), Badan Eksekutif Mahasiswa (BEM), dan Badan Perwakilan Mahasiswa (BPM).

## ✨ Fitur-Fitur Utama

### 1. **Sistem Autentikasi & Autorisasi**
- Registrasi akun mahasiswa dengan validasi NIM
- Login standar dengan email dan password
- Integrasi Google OAuth 2.0 untuk login sosial
- Sistem role-based access control (Mahasiswa, Admin, Superadmin, TU, BEM, BPM)
- Logout dan session management

### 2. **Manajemen Aspirasi Mahasiswa**
- ✏️ **CRUD Aspirasi**: Buat, baca, ubah, dan hapus aspirasi
- 📝 **Input Lengkap**: Judul, deskripsi, kategori, dan lampiran file
- 🔐 **Mode Anonim**: Pilihan untuk mengirim aspirasi secara anonim
- 📁 **Upload Lampiran**: Dukungan untuk mengunggah file bukti atau dokumen pendukung
- 🏷️ **Kategorisasi**: Organise aspirasi berdasarkan kategori yang sudah ditentukan
- 📊 **Status Tracking**: Monitor status aspirasi (draft, submitted, in-progress, completed, rejected)
- 🎯 **Dashboard Pribadi**: Lihat daftar 5 aspirasi terbaru di halaman dashboard

### 3. **Sistem Response & Komunikasi**
- 💬 **Response Ganda**: Mahasiswa dan admin dapat memberikan response
- 📝 **Diskusi Terstruktur**: Thread komunikasi terorganisir untuk setiap aspirasi
- 📎 **Lampiran Response**: Setiap response dapat dilengkapi dengan file pendukung
- 🗑️ **Kelola Response**: Hapus response yang telah dibuat
- 👤 **Identifikasi Pengirim**: Ketahui siapa yang memberikan response

### 4. **Dashboard Mahasiswa**
- 📊 Overview aspirasi personal
- 📈 Status aspirasi real-time
- 🔔 Notifikasi response dari admin
- ⚙️ Manajemen profil pribadi
- 🔑 Ubah password
- 👤 Edit informasi profil

### 5. **Dashboard Admin**
- 📋 **Kelola Aspirasi**: Lihat semua aspirasi dari mahasiswa
- 👁️ **Detail Aspirasi**: Review lengkap setiap aspirasi
- ✅ **Update Status**: Ubah status aspirasi (ditinjau, diproses, selesai, ditolak)
- 📤 **Berikan Response**: Reply langsung ke aspirasi mahasiswa
- 🏷️ **Kelola Kategori**: CRUD kategori aspirasi
- 📊 **Dashboard Analytics**: Statistik dan overview sistem
- 👤 **Profil Admin**: Kelola profil dan keamanan akun

### 6. **Fitur Public/Transparansi**
- 👁️ **Public Aspirations**: Lihat aspirasi yang sudah completed tanpa login
- 🔍 **Pencarian & Filter**: Temukan aspirasi berdasarkan kategori
- 📱 **Interface Responsif**: Akses dari desktop, tablet, atau mobile

### 7. **Manajemen Kategori**
- ➕ Tambah kategori aspirasi baru
- ✏️ Edit nama dan deskripsi kategori
- 🗑️ Hapus kategori yang tidak digunakan
- 📊 Statistik aspirasi per kategori

### 8. **Manajemen File & Lampiran**
- 📎 Upload multiple attachments
- 📁 Polymorphic relationship untuk aspirasi dan response
- 🔍 Track file metadata (nama, tipe, ukuran)
- 💾 Sistem penyimpanan terstruktur

### 9. **Soft Delete & Data Recovery**
- 🔄 Aspirasi yang dihapus dapat dipulihkan
- 🛡️ Data tidak benar-benar hilang dari database
- 📜 Audit trail untuk compliance

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12
- **Authentication**: Laravel Auth + Socialite (Google OAuth)
- **Database**: MySQL/SQLite
- **ORM**: Eloquent

### Frontend
- **CSS Framework**: Tailwind CSS 4.0
- **UI Components**: Bootstrap 5.3 (dengan Tailwind)
- **Build Tool**: Vite 7
- **Task Runner**: Concurrently (development)

### Dependencies
- **Laravel Socialite**: ^5.23 (Google OAuth)
- **Laravel Tinker**: ^2.10.1 (REPL)
- **PHPUnit**: ^11.5.3 (Testing)
- **Faker**: ^1.23 (Test Data)

## 📦 Struktur Database

### Tabel Utama

#### `users`
```
- id (primary key)
- name
- email (unique)
- nim (student ID)
- password
- role (mahasiswa, tu, bem, bpm, superadmin)
- google_id (optional)
- email_verified_at
- remember_token
- timestamps
```

#### `aspirations`
```
- id (primary key)
- user_id (foreign key to users)
- category_id (foreign key to categories)
- title
- description
- is_anonymous (boolean)
- status (draft, submitted, in-progress, completed, rejected)
- deleted_at (soft delete)
- timestamps
```

#### `responses`
```
- id (primary key)
- aspiration_id (foreign key to aspirations)
- user_id (foreign key to users)
- message
- sender_type (mahasiswa, admin, tu, bem, bpm)
- timestamps
```

#### `categories`
```
- id (primary key)
- name
- description
- timestamps
```

#### `attachments` (Polymorphic)
```
- id (primary key)
- attachable_id
- attachable_type (Aspiration atau Response)
- file_name
- file_path
- file_type
- file_size
- timestamps
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

Ini akan menjalankan:
- PHP development server
- Queue listener
- Log viewer
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
│   │   └── Controllers/
│   │       ├── Auth/              # Authentication controllers
│   │       ├── Mahasiswa/         # Student controllers
│   │       ├── Admin/             # Admin controllers
│   │       └── PublicAspirationController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Aspiration.php
│   │   ├── Response.php
│   │   ├── Category.php
│   │   └── Attachment.php
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
│   │   ├── admin/
│   │   ├── auth/
│   │   ├── mahasiswa/
│   │   ├── public/
│   │   ├── components/
│   │   └── layouts/
│   ├── css/
│   └── js/
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
├── bootstrap/
└── vendor/
```

## 🔐 Route Groups

### Public Routes
- `/public-aspirations` - Lihat aspirasi yang published
- `/register` - Form registrasi
- `/login` - Form login
- `/auth/google` - Google OAuth login

### Mahasiswa Routes (`/mahasiswa`)
- `dashboard` - Dashboard personal
- `aspirations.*` - Resource aspirations (CRUD)
- `responses.store` - Buat response
- `responses.destroy` - Hapus response
- `profile.edit/update` - Edit profil
- `profile.password` - Ubah password

### Admin Routes (`/admin`)
- `dashboard` - Admin dashboard
- `aspirations.index/show` - Lihat aspirasi
- `aspirations.status` - Update status
- `responses.store` - Buat response
- `categories.*` - Resource categories (CRUD)
- `profile.edit/update` - Edit profil
- `profile.password` - Ubah password

## 👥 Role & Izin

| Role | Deskripsi | Izin |
|------|-----------|------|
| **mahasiswa** | Mahasiswa | Membuat aspirasi, memberi balasan, melihat hasil |
| **admin** | Administrator | Mengelola aspirasi, memberi balasan, mengelola kategori, dashboard analytics |

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
- `POST /mahasiswa/aspirations/{id}/responses` - Add response
- `DELETE /mahasiswa/responses/{id}` - Delete response
- `POST /admin/aspirations/{id}/responses` - Admin response

### Categories
- `GET /admin/categories` - List kategori
- `POST /admin/categories` - Create kategori
- `PUT /admin/categories/{id}` - Update kategori
- `DELETE /admin/categories/{id}` - Delete kategori

## 🎨 UI Components

Menggunakan Blade templates dengan Tailwind CSS:
- Navigation bar
- Sidebar (admin)
- Modal dialogs
- Form components
- Card layouts
- Table displays
- Alert messages
- Status badges

## 🔒 Security Features

- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection
- ✅ Password hashing (bcrypt)
- ✅ Role-based access control
- ✅ Soft deletes (data retention)
- ✅ Secure file upload handling

## 📧 Seeder & Factory

### AdminSeeder
Membuat akun admin default dengan credentials untuk testing

### CategorySeeder  
Populate kategori aspirasi dasar

### UserFactory
Generate user dummy untuk testing

## 🤝 Kontribusi

1. Buat branch baru: `git checkout -b feature/AmazingFeature`
2. Commit changes: `git commit -m 'Add some AmazingFeature'`
3. Push ke branch: `git push origin feature/AmazingFeature`
4. Buka Pull Request

## 📄 Lisensi

MIT License - Lihat file LICENSE untuk detail

## 👨‍💻 Pengembang

Dikembangkan oleh tim AspirasiKu

## 📞 Support

Untuk pertanyaan atau laporan bug, silakan buat issue di repository ini.

---

**Terakhir diupdate**: November 2025
