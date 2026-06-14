<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RelatorioController;

Route::get('/teste-auth', function () {
    return auth()->check() ? 'logado' : 'deslogado';
});

//  rotas livres
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// rotas protegidas
Route::middleware('auth')->group(function () {

    // página inicial (lista de clientes)
    Route::get('/', [ClienteController::class, 'index']);

    // rotas de clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/novo', [ClienteController::class, 'create'])->name('clientes.create');
    Route::get('/relatorio-pdf', [RelatorioController::class, 'pdf'])->name('relatorio.pdf');
    Route::get('/relatorio-pdf', [ClienteController::class, 'exportarPdf'])->name('clientes.pdf');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    // rota de colchão (acordos mensais)
    Route::get('/colchao', [ClienteController::class, 'colchao'])->name('clientes.colchao');

    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});