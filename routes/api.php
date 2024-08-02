<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;

// Laravel default
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('places', [PlaceController::class, 'index']);
Route::post('places', [PlaceController::class, 'store']);
Route::get('places/{id}', [PlaceController::class, 'show']);
Route::put('places/{id}', [PlaceController::class, 'update']);
Route::delete('places/{id}', [PlaceController::class, 'destroy']);