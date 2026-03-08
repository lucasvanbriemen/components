<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get("/colors", [ApiController::class, "getThemeColors"]);