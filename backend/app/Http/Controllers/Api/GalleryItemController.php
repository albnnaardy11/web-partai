<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemController extends Controller
{
    public function index()
    {
        return response()->json(GalleryItem::all());
    }
}
