<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Akademik', 'description' => 'Perkuliahan, kurikulum, jadwal'],
            ['name' => 'Sarana Prasarana', 'description' => 'Fasilitas kampus, ruang kelas, lab'],
            ['name' => 'Administrasi & Kemahasiswaan', 'description' => 'Layanan TU, surat menyurat'],
            ['name' => 'Teknologi Informasi', 'description' => 'Website, sistem informasi, jaringan'],
            ['name' => 'Kegiatan & Organisasi', 'description' => 'UKM, BEM, kegiatan mahasiswa'],
            ['name' => 'Kebijakan Fakultas', 'description' => 'Peraturan, kebijakan kampus'],
            ['name' => 'Layanan Dosen', 'description' => 'Bimbingan, konsultasi dosen'],
            ['name' => 'Keamanan & Kenyamanan', 'description' => 'Keamanan kampus, parkir, kantin'],
            ['name' => 'Lainnya', 'description' => 'Aspirasi lain yang tidak termasuk kategori'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
