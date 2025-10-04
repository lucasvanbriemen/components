<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentController;

Route::post('/{any}', [ComponentController::class, 'index'])->where('any', '.*');
