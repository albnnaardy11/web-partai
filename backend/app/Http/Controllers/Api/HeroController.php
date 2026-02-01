<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class HeroController extends Controller
{
    #[OA\Get(path: '/api/hero', summary: 'Get hero section content', tags: ['General'])]
    #[OA\Response(response: 200, description: 'Successful operation')]
    public function index()

    {
        $hero = HeroSection::where('is_active', true)->latest()->first();

        if (!$hero) {
            return response()->json([
                'party_name' => 'Partai Ibu',
                'title' => 'Bersama Ibu, Bangun Indonesia yang Lebih Baik',
                'subtitle' => 'Menghadirkan kepemimpinan yang penuh kasih sayang, adil, dan berintegritas untuk kesejahteraan seluruh rakyat Indonesia.',
                'primary_button_text' => 'Daftar Sekarang',
                'secondary_button_text' => 'Pelajari Lebih Lanjut',
                'stat_members' => '50K+',
                'stat_provinces' => '34',
                'stat_programs' => '100+',
                'image_url' => null
            ]);
        }

        return response()->json([
            'party_name' => $hero->party_name,
            'title' => $hero->title,
            'subtitle' => $hero->subtitle,
            'primary_button_text' => $hero->primary_button_text,
            'secondary_button_text' => $hero->secondary_button_text,
            'stat_members' => $hero->stat_members,
            'stat_provinces' => $hero->stat_provinces,
            'stat_programs' => $hero->stat_programs,
            'image_url' => $hero->image_path ? asset('storage/' . $hero->image_path) : null,
        ]);
    }
}
