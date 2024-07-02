<?php

use App\Http\Controllers\API\PropertyAPIController;
use App\Http\Controllers\API\TaskAPIController;
use App\Http\Controllers\API\UserAPIController;
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

    Route::group(['prefix' => 'properties'], function () {
        Route::post('images', [PropertyAPIController::class, 'storeImages']);

        Route::put('{id}/status', [PropertyAPIController::class, 'updateStatus']);

        Route::get('{id}/images', [PropertyAPIController::class, 'getImages']);

        Route::get('{id}/user', [PropertyAPIController::class, 'getPropertyByUserId']);
    });

    Route::resource('property-boards', App\Http\Controllers\API\PropertyBoardsAPIController::class)
        ->except(['create', 'edit']);

    Route::get('current/user', [UserAPIController::class, 'currentUser']);

    Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
        ->except(['create', 'edit']);

    Route::post('users/{id}', [UserAPIController::class, 'show']);

    Route::resource('tasks', App\Http\Controllers\API\TaskAPIController::class)
        ->except(['create', 'edit']);

    Route::get('task/user/{user_id}', [TaskAPIController::class, 'taskByUser']);

    Route::resource('plans', App\Http\Controllers\API\PlanAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('cards', App\Http\Controllers\API\CardAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('mails', App\Http\Controllers\API\MailAPIController::class)
        ->except(['create', 'edit']);
});

Route::post('login', [UserAPIController::class, 'login']);

Route::post('register', [UserAPIController::class, 'store']);

Route::post('forget-password', [UserAPIController::class, 'forgetPassword']);

Route::post('reset-password', [UserAPIController::class, 'resetPassword']);