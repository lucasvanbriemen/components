<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class ComponentRegistry
{
    public static function paths(): array
    {
        return [
            'view' => resource_path('views/components'),
            'scss' => resource_path('scss/components'),
            'js'   => resource_path('js/components'),
        ];
    }

    public static function list(): array
    {
        $paths = self::paths();
        if (!File::exists($paths['view'])) {
            return [];
        }

        $names = [];
        foreach (File::files($paths['view']) as $file) {
            $name = $file->getFilename();
            if (str_ends_with($name, '.blade.php')) {
                $name = substr($name, 0, -10); // remove .blade.php
                $names[] = $name;
            }
        }

        // Only include components that have all three files
        return array_values(array_filter($names, function ($name) use ($paths) {
            return File::exists($paths['view'].DIRECTORY_SEPARATOR.$name.'.blade.php')
                && File::exists($paths['scss'].DIRECTORY_SEPARATOR.$name.'.scss')
                && File::exists($paths['js'].DIRECTORY_SEPARATOR.$name.'.js');
        }));
    }

    public static function get(string $name): ?array
    {
        $paths = self::paths();
        $viewPath = $paths['view'].DIRECTORY_SEPARATOR.$name.'.blade.php';
        $scssPath = $paths['scss'].DIRECTORY_SEPARATOR.$name.'.scss';
        $jsPath   = $paths['js'].DIRECTORY_SEPARATOR.$name.'.js';

        if (!File::exists($viewPath) || !File::exists($scssPath) || !File::exists($jsPath)) {
            return null;
        }

        return [
            'name' => $name,
            'paths' => [
                'view' => $viewPath,
                'scss' => $scssPath,
                'js'   => $jsPath,
            ],
            'view' => File::get($viewPath),
            'scss' => File::get($scssPath),
            'js'   => File::get($jsPath),
        ];
    }
}

