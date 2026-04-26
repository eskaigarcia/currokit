<?php

use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::redirect('ajustes', '/ajustes/perfil');

    Route::get('ajustes/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('ajustes/perfil', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::delete('ajustes/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('ajustes/seguridad', [SecurityController::class, 'edit'])->name('security.edit');

    Route::put('ajustes/credenciales', [SecurityController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('user-password.update');

    Route::inertia('ajustes/apariencia', 'settings/appearance')->name('appearance.edit');
});
