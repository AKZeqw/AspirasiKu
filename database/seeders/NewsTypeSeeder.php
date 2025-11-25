<?php

namespace Database\Seeders;

use App\Models\NewsType;
use Illuminate\Database\Seeder;

class NewsTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name'        => 'Open Recruitment',
                'description' => 'Berita terkait open recruitment panitia, anggota, atau pengurus UKM/ORMAWA.',
            ],
            [
                'name'        => 'Perlombaan',
                'description' => 'Informasi lomba, kompetisi, hackathon, dan kegiatan sejenis.',
            ],
            [
                'name'        => 'Prestasi Mahasiswa',
                'description' => 'Berita prestasi mahasiswa dan UKM/ORMAWA.',
            ],
            [
                'name'        => 'Acara Kampus',
                'description' => 'Seminar, workshop, webinar, dan acara kampus lainnya.',
            ],
            [
                'name'        => 'Beasiswa',
                'description' => 'Informasi beasiswa internal maupun eksternal.',
            ],
            [
                'name'        => 'Pengumuman',
                'description' => 'Pengumuman umum lain terkait kampus atau sistem.',
            ],
        ];

        foreach ($types as $type) {
            NewsType::firstOrCreate(
                ['name' => $type['name']],
                ['description' => $type['description']]
            );
        }
    }
}
