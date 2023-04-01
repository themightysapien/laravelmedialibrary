<?php

use Illuminate\Support\Facades\Route;
use Themightysapien\Medialibrary\Controllers\LibraryController;


Route::get('/', [LibraryController::class, 'index'])
    ->name('themightysapien.medialibrary.index');
