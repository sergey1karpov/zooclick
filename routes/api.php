<?php

use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);

Route::post('/{user}/create-channel', [ChannelController::class, 'createChannel'])->middleware(['auth:sanctum']);

