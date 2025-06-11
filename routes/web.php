<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\IdeaController;


Route::get('/', [IdeaController::class, 'index'])->name('index');
Route::post('/store', [IdeaController::class, 'store'])->name('store');
