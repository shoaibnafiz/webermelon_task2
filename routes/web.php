<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/statements', [TransactionController::class, 'statement'])->name('transactions.statement');
Route::get('/export/{month}', [TransactionController::class, 'export'])->name('transactions.export');
