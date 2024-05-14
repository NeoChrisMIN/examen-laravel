<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntradaController;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/entradas/listar', [EntradaController::class, 'index'])->name('entradas.index');
Route::get('/entradas/detalle/{id}', [EntradaController::class, 'show'])->name('entradas.show');

Route::get('/entradas/editar/{id}', [EntradaController::class, 'edit'])->name('entradas.edit');
Route::put('/entradas/update/{id}', [EntradaController::class, 'update'])->name('entradas.update');
Route::delete('/entradas/eliminar/{id}', [EntradaController::class, 'eliminar'])->name('entradas.eliminar');

Route::get('/entradas/crear', [EntradaController::class, 'crear'])->name('entradas.crear');
Route::post('/entradas/guardar', [EntradaController::class, 'guardar'])->name('entradas.guardar');

Route::get('/entradas/imprimir', [PdfController::class, 'generatePdf'])->name('entradas.pdf');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
