<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'dashboard');

Route::resource('equipments', EquipmentController::class)->only([
    'index', 'store'
]);

Route::resource('rentals', RentalController::class);

Route::get('/equipments/available', [EquipmentController::class, 'available'])->name('equipments.available');

