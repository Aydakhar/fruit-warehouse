<?php

use App\Http\Controllers\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/warehouse', [WarehouseController::class, 'index']);
Route::post('/warehouse/boxes', [WarehouseController::class, 'addBoxes']);
Route::patch('/warehouse/boxes/move', [WarehouseController::class, 'moveBoxes']);
Route::delete('/warehouse/boxes', [WarehouseController::class, 'removeBoxes']);
