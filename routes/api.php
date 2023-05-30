<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Themightysapien\MediaLibrary\Controllers\LibraryController;


Route::get(Config::get('mlibrary.route_resource'), [LibraryController::class, 'index'])
    ->name('themightysapien.medialibrary.index');

Route::post(Config::get('mlibrary.route_resource'), [LibraryController::class, 'store'])
    ->name('themightysapien.medialibrary.store');

Route::delete(Config::get('mlibrary.route_resource')."/{id}", [LibraryController::class, 'destroy'])
    ->name('themightysapien.medialibrary.destroy');
