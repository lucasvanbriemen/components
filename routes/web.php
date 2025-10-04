<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentController;

Route::get('/{any}', [ComponentController::class, 'index']);
