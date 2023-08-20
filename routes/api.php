<?php

use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/{user}/create-channel', [ChannelController::class, 'createChannel']);
    Route::get('/{user}/channels', [ChannelController::class, 'getChannel']);
    Route::post('/{channel}/create-theme', [ThemeController::class, 'createTheme']);
    Route::post('/{user}/{model}/{modelId}/like', [LikeController::class, 'likeTheme']);
});

