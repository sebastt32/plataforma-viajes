<?php

use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ViajeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogoController::class, 'index'])->name('home');
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/{viaje}', [CatalogoController::class, 'show'])->name('catalogo.show');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('rol:viajero')->group(function () {
        Route::resource('viajes', ViajeController::class);
        Route::resource('productos', ProductoController::class)->except(['show']);
        Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
        Route::patch('/solicitudes/{solicitud}/confirmar', [SolicitudController::class, 'confirmar'])->name('solicitudes.confirmar');
        Route::patch('/solicitudes/{solicitud}/rechazar', [SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
        Route::patch('/solicitudes/{solicitud}/en-camino', [SolicitudController::class, 'enCamino'])->name('solicitudes.en-camino');
        Route::patch('/solicitudes/{solicitud}/entregar', [SolicitudController::class, 'entregar'])->name('solicitudes.entregar');
    });

    Route::middleware('rol:comprador')->group(function () {
        Route::post('/catalogo/{producto}/solicitar', [SolicitudController::class, 'store'])->name('solicitudes.store');
        Route::get('/pedidos', [SolicitudController::class, 'pedidos'])->name('pedidos.index');
        Route::get('/pedidos/{solicitud}', [SolicitudController::class, 'show'])->name('pedidos.show');
        Route::post('/pedidos/{solicitud}/pagar', [PagoController::class, 'store'])->name('pagos.store');
    });
});

require __DIR__.'/auth.php';
