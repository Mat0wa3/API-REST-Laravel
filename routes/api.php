<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::prefix(('v1'))->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('loans', LoanController::class);
});
