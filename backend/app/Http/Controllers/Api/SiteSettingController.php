<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->mapWithKeys(function ($item) {
            return [$item->key => $item->value];
        });
        return response()->json($settings);
    }
}
