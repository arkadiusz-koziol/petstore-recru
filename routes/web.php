<?php

use App\Http\Controllers\PetDeleteController;
use App\Http\Controllers\PetShowController;
use App\Http\Controllers\PetStoreController;
use App\Http\Controllers\PetUpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pets.index');
})->name('pet.form');

Route::prefix('pet')->group(function () {
    Route::post('/', PetStoreController::class)->name('pet.store');
    Route::put('/{petId}', PetUpdateController::class)->name('pet.update');
    Route::delete('/{petId}', PetDeleteController::class)->name('pet.delete');
    Route::get('/{petId?}', PetShowController::class)->name('pet.show');
});

Route::prefix('form')->group(function () {
    Route::get('/pet/create', function () { return view('pets.create'); })->name('pet.form.create');
    Route::get('/pet/show', function () { return view('pets.show'); })->name('pet.form.show');
    Route::get('/pet/update', function () { return view('pets.update'); })->name('pet.form.update');
    Route::get('/pet/delete', function () { return view('pets.delete'); })->name('pet.form.delete');
});
