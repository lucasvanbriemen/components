<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ApiController extends Controller
{
    public function getThemeColors(Request $request)
    {
        $theme = request()->query("theme");

        $path = resource_path("json/colors/{$theme}.json");
        $colors = File::get($path);

        return response($colors, 200)
            ->header("Content-Type", "application/json");
    }
}
