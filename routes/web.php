<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pagamento', [VendaController::class, 'paymentIndex'])->name('pagamento.index');

Route::get('/vendas', [VendaController::class, 'index'])->name('vendas.index');

Route::get('/vendas/create', [VendaController::class, 'create'])->name('vendas.create');

Route::post('/vendas/store', [VendaController::class, 'store']);

Route::delete('/vendas/{id}', [VendaController::class, 'destroy']);

Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');

Route::post('/clientes/store', [ClienteController::class, 'store']);

Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');;

Route::post('/items/store', [ItemController::class, 'store']);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
