<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;

// Laravel default
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Places CRUD
Route::prefix('places')->group(function () {
    Route::get('/', [PlaceController::class, 'index'])->name('places.index');
    Route::post('/', [PlaceController::class, 'store'])->name('places.store');
    Route::get('{id}', [PlaceController::class, 'show'])->name('places.show');
    Route::put('{id}', [PlaceController::class, 'update'])->name('places.update');
    Route::delete('{id}', [PlaceController::class, 'destroy'])->name('places.destroy');
});
