<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Partai Ibu Luncurkan Program Beasiswa untuk 50,000 Anak Indonesia',
                'slug' => 'beasiswa-ibu-bangsa-50000',
                'excerpt' => 'Program beasiswa pendidikan gratis diluncurkan untuk membantu anak-anak Indonesia dari keluarga kurang mampu.',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'badge' => 'Program',
                'published_date' => now(),
            ],
            [
                'title' => 'Kunjungan ke 10 Provinsi: Mendengar Aspirasi Ibu-Ibu Indonesia',
                'slug' => 'kunjungan-10-provinsi-aspirasi',
                'excerpt' => 'Ketua Umum Partai Ibu melakukan kunjungan kerja ke berbagai provinsi untuk mendengar langsung aspirasi masyarakat.',
                'content' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'badge' => 'Kegiatan',
                'published_date' => now()->subDays(2),
            ],
            [
                'title' => 'UMKM Binaan Partai Ibu Raih Omzet Miliaran Rupiah',
                'slug' => 'umkm-binaan-meraih-miliaran',
                'excerpt' => 'Ratusan UMKM yang dibina Partai Ibu berhasil meningkatkan omzet hingga ratusan persen dalam 6 bulan terakhir.',
                'content' => 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris.',
                'badge' => 'Prestasi',
                'published_date' => now()->subDays(5),
            ],
        ];

        foreach ($articles as $a) {
            Article::updateOrCreate(['slug' => $a['slug']], $a);
        }
    }
}
