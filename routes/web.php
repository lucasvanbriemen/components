<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentController;

Route::get('/', function () {
    return view('lookbook');
});

Route::post('/{any}', [ComponentController::class, 'index'])->where('any', '.*');
