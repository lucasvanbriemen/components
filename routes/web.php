<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\FileController;
use App\Http\Middleware\IsLoggedIn;

Route::get('/', function () {
    return view('lookbook');
});

// File manager page — requires a valid login session.
Route::middleware(IsLoggedIn::class)->get('/files', function () {
    return view('files');
});

// Public media serving (inline view + ?download). Must sit before the
// catch-all so the path is matched directly.
Route::get('/media/{path}', [FileController::class, 'show'])
    ->where('path', '.*')
    ->name('media.show');

Route::post('/{any}', [ComponentController::class, 'index'])->where('any', '.*');
