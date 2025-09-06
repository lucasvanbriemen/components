<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

// Return colors.json
Route::get("/colors", function () {
    $path = resource_path("json/colors.json");
    if (!File::exists($path)) {
        return response()->json(["message" => "Colors file not found."], 404);
    }
    $colors = File::get($path);
    return response($colors, 200)->header("Content-Type", "application/json");
});