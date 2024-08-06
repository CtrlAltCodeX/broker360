<?php

use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PropertyBoardsController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyFeaturesController;
use App\Http\Controllers\PropertyTypeController;
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

        Route::get('show/{id}', [UserController::class, 'show'])
            ->name('admin.users.show');

        Route::get('edit/{id}', [UserController::class, 'edit'])
            ->name('admin.users.edit');

        Route::put('update/{id}', [UserController::class, 'update'])
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

        Route::get('show/{id}', [ContactsController::class, 'show'])
            ->name('admin.contacts.show');

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

        Route::get('show/{id}', [PropertyController::class, 'show'])
            ->name('admin.properties.show');

        Route::get('create', [PropertyController::class, 'create'])
            ->name('admin.properties.create');

        Route::post('create', [PropertyController::class, 'store'])
            ->name('admin.properties.store');

        Route::get('edit/{id}', [PropertyController::class, 'edit'])
            ->name('admin.properties.edit');

        Route::put('update/{id}', [PropertyController::class, 'update'])
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

    Route::prefix('plans')->group(function () {
        Route::get('index', [PlanController::class, 'index'])
            ->name('admin.plans.index');

        Route::get('create', [PlanController::class, 'create'])
            ->name('admin.plans.create');

        Route::post('create', [PlanController::class, 'store'])
            ->name('admin.plans.store');

        Route::get('edit/{id}', [PlanController::class, 'edit'])
            ->name('admin.plans.edit');

        Route::put('update/{id}', [PlanController::class, 'update'])
            ->name('admin.plans.update');

        Route::get('delete/{id}', [PlanController::class, 'destroy'])
            ->name('admin.plans.delete');
    });

    Route::prefix('features')->group(function () {
        Route::get('index', [PropertyFeaturesController::class, 'index'])
            ->name('admin.features.index');

        Route::get('create', [PropertyFeaturesController::class, 'create'])
            ->name('admin.features.create');

        Route::post('create', [PropertyFeaturesController::class, 'store'])
            ->name('admin.features.store');

        Route::get('edit/{id}', [PropertyFeaturesController::class, 'edit'])
            ->name('admin.features.edit');

        Route::post('update/{id}', [PropertyFeaturesController::class, 'update'])
            ->name('admin.features.update');

        Route::get('delete/{id}', [PropertyFeaturesController::class, 'destroy'])
            ->name('admin.features.delete');
    });

    Route::prefix('type')->group(function () {
        Route::get('index', [PropertyTypeController::class, 'index'])
            ->name('admin.type.index');

        Route::get('create', [PropertyTypeController::class, 'create'])
            ->name('admin.type.create');

        Route::post('create', [PropertyTypeController::class, 'store'])
            ->name('admin.type.store');

        Route::get('edit/{id}', [PropertyTypeController::class, 'edit'])
            ->name('admin.type.edit');

        Route::post('update/{id}', [PropertyTypeController::class, 'update'])
            ->name('admin.type.update');

        Route::get('delete/{id}', [PropertyTypeController::class, 'destroy'])
            ->name('admin.type.delete');
    });

    Route::prefix('collaboration')->group(function () {
        Route::get('create', [UserController::class, 'collaborationCreate'])
            ->name('admin.collaboration.create');

        Route::get('', [UserController::class, 'collaborationIndex'])
            ->name('admin.collaboration.index');

        Route::post('collaboration', [UserController::class, 'inviteCollaboration'])
            ->name('admin.collaboration.store');

        Route::get('edit/{id}', [UserController::class, 'collaborationEdit'])
            ->name('admin.collaboration.edit');

        Route::post('update/{id}', [UserController::class, 'collaborationUpdate'])
            ->name('admin.collaboration.update');

        Route::get('delete/{id}', [UserController::class, 'collaborationDelete'])
            ->name('admin.collaboration.delete');
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
