<?php

use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [ChamadoController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [ChamadoController::class, 'index'])->name('dashboard');
    Route::get('/chamado', [ChamadoController::class, 'chamado'])->name('dashboard.chamado');
    Route::post('/chamado', [ChamadoController::class, 'store'])->name('chamado.store');

    // Abaixo breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
