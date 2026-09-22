<?php

use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/', [ChamadoController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [ChamadoController::class, 'index'])->name('dashboard');
    Route::get('/chamado', [ChamadoController::class, 'chamado'])->name('dashboard.chamado');
    Route::post('/chamado', [ChamadoController::class, 'store'])->name('chamado.store');
    Route::post('/chamado/{chamado}/assumir', [ChamadoController::class, 'assumir'])->name('chamado.assumir');
    Route::get('/chamado/{chamado}', [ChamadoController::class, 'show'])->name('chamado.show');
    Route::post('/chamado/{chamado}/responder', [ChamadoController::class, 'responder'])->name('chamado.responder');
    Route::patch('/chamado/{chamado}', [ChamadoController::class, 'atualizar'])->name('chamado.atualizar');
    Route::post('/chamado/{chamado}/fechar', [ChamadoController::class, 'fechar'])->name('chamado.fechar');
    Route::get('/admin/usuarios', [AdminUserController::class, 'index'])->name('admin.usuarios.index');
    Route::post('/admin/usuarios', [AdminUserController::class, 'store'])->name('admin.usuarios.store');
    Route::patch('/admin/usuarios/{usuario}', [AdminUserController::class, 'update'])->name('admin.usuarios.update');

    // Abaixo breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
