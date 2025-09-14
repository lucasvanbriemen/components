<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Support\ComponentRegistry;

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

// Return a component's view, scss, and js as JSON
Route::get('/{component}', function (string $component) {
  // Avoid clashing with other known api routes
  if ($component === 'colors') {
    return response()->json(['message' => 'Not a component'], 404);
  }

  $data = ComponentRegistry::get($component);
  if (!$data) {
    return response()->json(["message" => "Component files not found."], 404);
  }

  return response()->json([
    'name' => $data['name'],
    'view' => $data['view'],
    'scss' => $data['scss'],
    'js'   => $data['js'],
  ]);
})->where('component', '^(?!colors$)[A-Za-z0-9_-]+$');
