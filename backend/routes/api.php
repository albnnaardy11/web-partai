<?php

use App\Http\Controllers\Api\HeroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/hero', [App\Http\Controllers\Api\HeroController::class, 'index']);
Route::get('/about', [App\Http\Controllers\Api\AboutController::class, 'index']);
Route::get('/chairperson-message', [App\Http\Controllers\Api\ChairpersonMessageController::class, 'index']);
Route::get('/values', [App\Http\Controllers\Api\ValueController::class, 'index']);
Route::get('/programs', [App\Http\Controllers\Api\ProgramController::class, 'index']);
Route::get('/region-stats', [App\Http\Controllers\Api\RegionStatController::class, 'index']);
Route::get('/articles', [App\Http\Controllers\Api\ArticleController::class, 'index']);
Route::get('/gallery', [App\Http\Controllers\Api\GalleryItemController::class, 'index']);
Route::get('/settings', [App\Http\Controllers\Api\SiteSettingController::class, 'index']);
Route::post('/register', [App\Http\Controllers\Api\MemberRegistrationController::class, 'register']);
Route::post('/aspirations', [App\Http\Controllers\Api\AspirationController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});