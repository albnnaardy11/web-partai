<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AboutSection;

use OpenApi\Attributes as OA;

class AboutController extends Controller
{
    #[OA\Get(path: '/api/about', summary: 'Get about section content', tags: ['General'])]
    #[OA\Response(response: 200, description: 'Successful operation')]
    public function index()

    {
        $about = AboutSection::where('is_active', true)->latest()->first();

        if (!$about) {
            return response()->json([
                'header_badge' => 'Tentang Kami',
                'header_title' => 'Partai Ibu untuk <span class="text-danger">Indonesia</span>',
                'header_description' => 'Kami percaya bahwa kekuatan kasih sayang seorang ibu dapat mengubah Indonesia menjadi negara yang lebih adil, sejahtera, dan penuh kepedulian.',
                'feature_1_title' => 'Visi Indonesia',
                'feature_1_description' => 'Mewujudkan Indonesia yang maju, adil, dan sejahtera dengan semangat gotong royong and kepedulian untuk seluruh rakyat dari Sabang sampai Merauke.',
                'feature_2_title' => 'Kepemimpinan Ibu',
                'feature_2_description' => 'Menghadirkan kepemimpinan yang penuh kasih sayang, tegas namun bijaksana, dan selalu mengutamakan kepentingan keluarga Indonesia.',
                'feature_3_title' => 'Integritas Tinggi',
                'feature_3_description' => 'Berkomitmen untuk menjaga kejujuran, transparansi, dan akuntabilitas dalam setiap langkah untuk membangun kepercayaan rakyat Indonesia.',
                'banner_title' => 'Merah Putih Indonesia',
                'banner_description' => 'Kami bangga menjadi bagian dari Indonesia. Dengan semangat merah putih, kami berkomitmen untuk mengabdi kepada negara dan seluruh rakyat Indonesia dengan sepenuh hati.',
            ]);
        }

        return response()->json([
            'header_badge' => $about->header_badge,
            'header_title' => $about->header_title,
            'header_description' => $about->header_description,
            'feature_1_title' => $about->feature_1_title,
            'feature_1_description' => $about->feature_1_description,
            'feature_2_title' => $about->feature_2_title,
            'feature_2_description' => $about->feature_2_description,
            'feature_3_title' => $about->feature_3_title,
            'feature_3_description' => $about->feature_3_description,
            'banner_title' => $about->banner_title,
            'banner_description' => $about->banner_description,
        ]);
    }
}

