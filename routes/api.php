<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FileController;
use App\Http\Middleware\IsLoggedIn;

Route::get("/colors", [ApiController::class, "getThemeColors"]);
Route::post("/notify", [ApiController::class, "sendNotification"]);

// Files: reading (listing) is public, mutations require a valid session.
Route::get("/files", [FileController::class, "index"])->name("files.index");

Route::middleware(IsLoggedIn::class)->group(function () {
    Route::post("/files", [FileController::class, "store"])->name("files.store");
    Route::post("/files/{path}", [FileController::class, "update"])
        ->where("path", ".*")
        ->name("files.update");
});
