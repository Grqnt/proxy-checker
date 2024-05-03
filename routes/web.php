<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CheckerController;
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

Route::get('/', [CheckerController::class, 'index']);
Route::post('/', [CheckerController::class, 'start'])->name('start_check_proxies');

Route::group(['prefix' => '/archive'], function () {
    Route::get('/', [ArchiveController::class, 'index'])->name('archives');
    Route::get('/{id}', [ArchiveController::class, 'get'])->name('archive');
});
