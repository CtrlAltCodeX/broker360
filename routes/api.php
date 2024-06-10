<?php

use App\Http\Controllers\API\PropertyAPIController;
use App\Http\Controllers\API\UserAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function () {
        return auth()->user();
    });

    Route::resource('contacts', App\Http\Controllers\API\ContactAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('properties', App\Http\Controllers\API\PropertyAPIController::class)
        ->except(['create', 'edit']);

    Route::post('properties/images', [PropertyAPIController::class, 'storeImages']);

    Route::post('properties/{id}/images', [PropertyAPIController::class, 'getImages']);

    Route::get('properties/{id}/user', [PropertyAPIController::class, 'getPropertyByUserId']);

    Route::resource('property-boards', App\Http\Controllers\API\PropertyBoardsAPIController::class)
        ->except(['create', 'edit']);

    Route::get('current/user', [UserAPIController::class, 'currentUser']);

    Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
        ->except(['create', 'edit']);
});

Route::post('login', [UserAPIController::class, 'login']);

Route::post('forget-password', [UserAPIController::class, 'forgetPassword']);

Route::post('reset-password', [UserAPIController::class, 'resetPassword']);
