<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class)->except('destroy', 'update');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/posts/getByTag/{tagName}', [PostController::class,'showByTag']);
Route::apiResource('/posts', PostController::class)->except('destroy', 'store', 'update');

Route::apiResource('/tags', TagController::class)->except('destroy', 'store', 'update');

Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class,'me']);

        Route::apiResource('/posts', PostController::class)->only('destroy', 'store', 'update');

        Route::apiResource('/users', UserController::class)->only('destroy', 'update');

        Route::apiResource('/tags', TagController::class)->only('destroy', 'store', 'update');
    }
);
