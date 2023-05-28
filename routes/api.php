<?php

use Illuminate\Support\Facades\Route;
use Themightysapien\MediaLibrary\Controllers\LibraryController;


Route::get('/tsmedialibrary', [LibraryController::class, 'index'])
    ->name('themightysapien.medialibrary.index');
Route::post('/tsmedialibrary', [LibraryController::class, 'store'])
    ->name('themightysapien.medialibrary.store');
