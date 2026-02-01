<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Value;
use App\Models\Program;
use App\Models\RegionStat;
use App\Models\Article;
use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\ChairpersonMessage;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Hero
        HeroSection::create([
            'party_name' => 'Partai Ibu',
            'title' => 'Bersama Ibu, Bangun Indonesia yang Lebih Baik',
            'subtitle' => 'Menghadirkan kepemimpinan yang penuh kasih sayang, adil, dan berintegritas untuk kesejahteraan seluruh rakyat Indonesia.',
            'primary_button_text' => 'Daftar Sekarang',
            'secondary_button_text' => 'Pelajari Lebih Lanjut',
            'stat_members' => '50K+',
            'stat_provinces' => '38',
            'stat_programs' => '100+',
            'is_active' => true
        ]);

        // About
        AboutSection::create([
            'header_badge' => 'Tentang Kami',
            'header_title' => 'Partai Ibu untuk Indonesia',
            'header_description' => 'Kami percaya bahwa kekuatan kasih sayang seorang ibu dapat mengubah Indonesia menjadi negara yang lebih adil, sejahtera, dan penuh kepedulian.',
            'feature_1_title' => 'Visi Indonesia',
            'feature_1_description' => 'Mewujudkan Indonesia yang maju, adil, dan sejahtera dengan semangat gotong royong.',
            'feature_2_title' => 'Kepemimpinan Ibu',
            'feature_2_description' => 'Menghadirkan kepemimpinan yang penuh kasih sayang, tegas namun bijaksana.',
            'feature_3_title' => 'Integritas Tinggi',
            'feature_3_description' => 'Berkomitmen untuk menjaga kejujuran dan transparansi.',
            'banner_title' => 'Merah Putih Indonesia',
            'banner_description' => 'Kami bangga menjadi bagian dari Indonesia.',
            'is_active' => true
        ]);

        // Values
        $values = [
            ['title' => 'Kasih Sayang', 'description' => 'Mengutamakan empati dalam setiap kebijakan publik.', 'order' => 1],
            ['title' => 'Integritas', 'description' => 'Kejujuran adalah pondasi utama pembangunan bangsa.', 'order' => 2],
            ['title' => 'Keadilan', 'description' => 'Memastikan hak setiap warga negara terpenuhi tanpa pandang bulu.', 'order' => 3],
            ['title' => 'Keluarga', 'description' => 'Memperkuat ketahanan keluarga sebagai unit terkecil bangsa.', 'order' => 4],
        ];
        foreach($values as $v) Value::create($v);

        // Programs
        $programs = [
            ['title' => 'Beasiswa Ibu Bangsa', 'description' => 'Program dukungan pendidikan untuk talenta muda Indonesia.', 'stats_text' => '10.000+ Penerima'],
            ['title' => 'Kesehatan Semesta', 'description' => 'Layanan kesehatan gratis untuk ibu dan anak.', 'stats_text' => '500+ Klinik'],
        ];
        foreach($programs as $p) Program::create($p);

        // Region Stats
        $regions = [
            ['region_name' => 'DKI Jakarta', 'branch_count' => 45, 'member_count_text' => '1.2M+', 'status' => 'Pusat'],
            ['region_name' => 'Jawa Barat', 'branch_count' => 120, 'member_count_text' => '3.5M+', 'status' => 'Sangat Aktif'],
        ];
        foreach($regions as $r) RegionStat::create($r);

        // Settings
        SiteSetting::create(['key' => 'address', 'value' => 'Jl. Merdeka No. 1, Jakarta Pusat', 'type' => 'text', 'group' => 'contact']);
        SiteSetting::create(['key' => 'phone', 'value' => '+62 21 1234 5678', 'type' => 'text', 'group' => 'contact']);
        SiteSetting::create(['key' => 'email', 'value' => 'kontak@partaiibu.id', 'type' => 'text', 'group' => 'contact']);

        // Articles
        $articles = [
            [
                'title' => 'Partai Ibu Luncurkan Program Beasiswa untuk 50,000 Anak Indonesia',
                'excerpt' => 'Program beasiswa pendidikan gratis diluncurkan untuk membantu anak-anak Indonesia dari keluarga kurang mampu.',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'badge' => 'Program',
                'published_date' => now(),
                'status' => 'published'
            ],
            [
                'title' => 'Kunjungan ke 10 Provinsi: Mendengar Aspirasi Ibu-Ibu Indonesia',
                'excerpt' => 'Ketua Umum Partai Ibu melakukan kunjungan kerja ke berbagai provinsi untuk mendengar langsung aspirasi masyarakat.',
                'content' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'badge' => 'Kegiatan',
                'published_date' => now()->subDays(2),
                'status' => 'published'
            ],
            [
                'title' => 'UMKM Binaan Partai Ibu Raih Omzet Miliaran Rupiah',
                'excerpt' => 'Ratusan UMKM yang dibina Partai Ibu berhasil meningkatkan omzet hingga ratusan persen dalam 6 bulan terakhir.',
                'content' => 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris.',
                'badge' => 'Prestasi',
                'published_date' => now()->subDays(5),
                'status' => 'published'
            ],
        ];
        foreach($articles as $a) Article::create($a);
    }
}
