<?php

use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyBoardsController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::prefix('users')->group(function () {
        Route::get('list', [UserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('all-users', [UserController::class, 'all'])
            ->name('admin.all.users');
    
        Route::get('create', [UserController::class, 'create'])
            ->name('admin.users.create');
    
        Route::post('create', [UserController::class, 'store'])
            ->name('admin.users.store');
    
        Route::get('edit/{id}', [UserController::class, 'edit'])
            ->name('admin.users.edit');
    
        Route::post('update/{id}', [UserController::class, 'update'])
            ->name('admin.users.update');
    
        Route::get('delete/{id}', [UserController::class, 'destroy'])
            ->name('admin.users.delete');
    });
    
    Route::prefix('contacts')->group(function () {
        Route::get('list', [ContactsController::class, 'index'])
            ->name('admin.contacts.index');
    
        Route::get('create', [ContactsController::class, 'create'])
            ->name('admin.contacts.create');
    
        Route::post('create', [ContactsController::class, 'store'])
            ->name('admin.contacts.store');
    
        Route::get('edit/{id}', [ContactsController::class, 'edit'])
            ->name('admin.contacts.edit');
    
        Route::post('update/{id}', [ContactsController::class, 'update'])
            ->name('admin.contacts.update');
    
        Route::get('delete/{id}', [ContactsController::class, 'destroy'])
            ->name('admin.contacts.delete');
    });
    
    Route::prefix('property')->group(function () {
        Route::get('list', [PropertyController::class, 'index'])
            ->name('admin.properties.index');
    
        Route::get('create', [PropertyController::class, 'create'])
            ->name('admin.properties.create');
    
        Route::post('create', [PropertyController::class, 'store'])
            ->name('admin.properties.store');
    
        Route::get('edit/{id}', [PropertyController::class, 'edit'])
            ->name('admin.properties.edit');
    
        Route::post('update/{id}', [PropertyController::class, 'update'])
            ->name('admin.properties.update');
    
        Route::get('delete/{id}', [PropertyController::class, 'destroy'])
            ->name('admin.properties.delete');
    });
    
    Route::prefix('board')->group(function () {
        Route::get('list', [PropertyBoardsController::class, 'index'])
            ->name('admin.boards.index');
    
        Route::get('create', [PropertyBoardsController::class, 'create'])
            ->name('admin.boards.create');
    
        Route::post('create', [PropertyBoardsController::class, 'store'])
            ->name('admin.boards.store');
    
        Route::get('edit/{id}', [PropertyBoardsController::class, 'edit'])
            ->name('admin.boards.edit');
    
        Route::post('update/{id}', [PropertyBoardsController::class, 'update'])
            ->name('admin.boards.update');
    
        Route::get('delete/{id}', [PropertyBoardsController::class, 'destroy'])
            ->name('admin.boards.delete');
    });
});


Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
