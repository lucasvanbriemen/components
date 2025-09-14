<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Support\ComponentRegistry;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lookbook', function () {
    $components = ComponentRegistry::list();
    return view('lookbook.index', [
        'components' => $components,
    ]);
});

Route::get('/lookbook/{component}', function (string $component) {
    $data = ComponentRegistry::get($component);
    if (!$data) {
        abort(404);
    }

    return view('lookbook.show', [
        'component' => $data,
    ]);
})->where('component', '[A-Za-z0-9_-]+');
