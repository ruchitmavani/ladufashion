<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/firms', [App\Http\Controllers\FirmController::class, 'index'])->name('firms');
Route::get('/firms/{id}/edit', [App\Http\Controllers\FirmController::class, 'edit'])->name('firm.edit');
Route::post('/firms/store', [App\Http\Controllers\FirmController::class, 'store'])->name('firm.store');
Route::get('/firms/{id}/delete', [App\Http\Controllers\FirmController::class, 'destroy'])->name('firm.delete');
Route::post('/bills/store', [App\Http\Controllers\BillsController::class, 'store'])->name('save');
Route::get('/bills/{id}/edit', [App\Http\Controllers\BillsController::class, 'edit'])->name('bills.edit');
Route::post('/bills/update', [App\Http\Controllers\BillsController::class, 'update'])->name('bills.update');
Route::get('/all-bills', [App\Http\Controllers\BillsController::class, 'index'])->name('bills');
