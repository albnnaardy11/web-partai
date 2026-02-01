<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class GalleryItemController extends Controller
{
    #[OA\Get(path: '/api/gallery-items', summary: 'Get list of gallery items', tags: ['General'])]
    #[OA\Response(response: 200, description: 'Successful operation')]
    public function index()

    {
        return response()->json(GalleryItem::all());
    }
}
