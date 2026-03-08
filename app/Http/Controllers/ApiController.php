<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

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

    public function sendNotification(Request $request)
    {
        $title = $request->input("title");
        $message = $request->input("message");
        $image = $request->input("image");
        $url = $request->input("url");

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.pushcut.io/y7tSaWIeA3-uV6RQTbjE3/notifications/My%20First%20Notification', [
            'title' => $title,
            'text' => $message,
            'image' => $image,
            'defaultAction' => [
                'url' => $url,
            ],
        ]);

        return response()->json([
            "success" => $response->successful(),
            "message" => "Notification sent: {$message}"
        ]);
    }
}
