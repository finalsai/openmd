<?php

use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ContentController::class, 'index'])->name('content.index');
Route::post('/', [ContentController::class, 'store']);

Route::get('/{content:slug}', [ContentController::class, 'show'])->name('content.show');
Route::delete('/{content:slug}', [ContentController::class, 'destroy'])->name('content.destroy');

Route::get('/{content:slug}/edit', [ContentController::class, 'edit'])->name('content.edit');
Route::put('/{content:slug}', [ContentController::class, 'update'])->name('content.update');

Route::post('/{content:slug}/auth', [ContentController::class, 'auth'])->name('content.auth');
