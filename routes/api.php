<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

Route::post('/players', [PlayerController::class, 'store']);
Route::get('/players', [PlayerController::class, 'index']);

Route::post('/tournaments', [TournamentController::class, 'store']);
Route::post('/tournaments/{tournament}/run', [TournamentController::class, 'run']);
Route::get('/tournaments/{tournament}', [TournamentController::class, 'show']);
