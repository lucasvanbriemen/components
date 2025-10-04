<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get("/colors", function () {
  $theme = request()->query("theme");

  if (!$theme) {
    return response()->json(["message" => "Missing theme parameter."], 400);
  }

  $path = resource_path("json/colors/{$theme}.json");

  if (!File::exists($path)) {
    return response()->json(["message" => "Theme not found."], 404);
  }

  $colors = File::get($path);

  return response($colors, 200)
    ->header("Content-Type", "application/json");
});
