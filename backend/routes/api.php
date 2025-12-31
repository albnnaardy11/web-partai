<?php

use App\Http\Controllers\Api\HeroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/hero', [App\Http\Controllers\Api\HeroController::class, 'index']);
Route::get('/about', [App\Http\Controllers\Api\AboutController::class, 'index']);
Route::get('/chairperson-message', [App\Http\Controllers\Api\ChairpersonMessageController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
