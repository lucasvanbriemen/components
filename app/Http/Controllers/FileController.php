<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    private const DISK = 'public';

    private const BASE_DIR = 'uploads';

    public function index(): JsonResponse
    {
        $disk = Storage::disk(self::DISK);

        $files = collect($disk->allFiles(self::BASE_DIR))
            ->map(fn (string $path) => $this->describe($path))
            ->sortByDesc('last_modified')
            ->values();

        return response()->json(['files' => $files]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file', 'max:51200'], // 50 MB per file
        ]);

        $pathPrefix = self::BASE_DIR.'/'.date('Y/m/d');

        $out = [];

        foreach ($request->file('files', []) as $file) {
            $original = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $basename = pathinfo($original, PATHINFO_FILENAME);
            $safeBase = Str::slug($basename) ?: 'file';

            // example: uploads/2026/06/13/screenshot-ysS4TjId.png
            $filename = $safeBase.'-'.Str::random(8).($extension ? ".{$extension}" : '');
            $storedPath = $file->storeAs($pathPrefix, $filename, self::DISK);

            $out[] = $this->describe($storedPath, $original);
        }

        return response()->json(['files' => $out], 201);
    }

    public function update(Request $request, string $path): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:51200'], // 50 MB
        ]);

        $path = ltrim($path, '/');
        $disk = Storage::disk(self::DISK);

        abort_unless($this->isAllowed($path) && $disk->exists($path), 404);

        $disk->put($path, $request->file('file')->get());

        return response()->json(['file' => $this->describe($path)]);
    }

    public function show(Request $request, string $path)
    {
        $path = ltrim($path, '/');
        $disk = Storage::disk(self::DISK);

        abort_unless($this->isAllowed($path) && $disk->exists($path), 404);

        $mime = $disk->mimeType($path) ?: 'application/octet-stream';
        $filename = basename($path);

        return new Response($disk->get($path), 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    private function describe(string $path, ?string $name = null): array
    {
        $disk = Storage::disk(self::DISK);

        return [
            'name' => $name ?? basename($path),
            'path' => $path,
            'url' => route('media.show', ['path' => $path]),
            'type' => $disk->mimeType($path) ?: 'application/octet-stream',
            'size' => $disk->size($path),
            'last_modified' => $disk->lastModified($path),
        ];
    }

    /**
     * Guard against path traversal and access outside the uploads directory.
     */
    private function isAllowed(string $path): bool
    {
        return ! str_contains($path, '..') && Str::startsWith($path, self::BASE_DIR.'/');
    }
}
