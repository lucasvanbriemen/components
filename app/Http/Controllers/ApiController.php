<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getThemeColors(Request $request)
    {
        $path = resource_path("json/theme.json");
        $colors = json_decode(File::get($path), true);

        $withStates = [];
        foreach ($colors as $name => $modes) {
            $withStates[$name] = $modes;
            foreach ([8, 12] as $transparency) {
                $alpha = (100 - $transparency) / 100;
                $withStates["{$name}-{$transparency}"] = [
                    "dark" => $this->withAlpha($modes["dark"], $alpha),
                    "light" => $this->withAlpha($modes["light"], $alpha),
                ];
            }
        }

        return response()->json($withStates);
    }

    private function withAlpha(string $rgb, float $alpha): string
    {
        return preg_replace('/\)\s*$/', " / {$alpha})", $rgb);
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
