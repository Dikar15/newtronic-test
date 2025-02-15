<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Case1Controller;
use App\Http\Controllers\Case2Controller;
use App\Http\Controllers\Case3Controller;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KursController;

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

Route::get('/', function () {
    return view('welcome');
});
//ROUTE MENU
Route::get('menu/case1', [Case1Controller::class, 'index'])->name('menu.case1');
Route::get('menu/case2', [Case2Controller::class, 'index'])->name('menu.case2');
Route::get('menu/case3', [Case3Controller::class, 'index'])->name('menu.case3');
//ROUTE CASE 1
Route::get('produk/index', [ProdukController::class, 'index'])->name('produk.index');
Route::post('produk/store', [ProdukController::class, 'store'])->name('produk.store');
Route::delete('produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
Route::get('produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
Route::post('produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('transaksi/delete/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
Route::get('transaksi/index', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('transaksi/detil/{id}', [TransaksiController::class, 'detil'])->name('transaksi.detil');
Route::delete('transaksi/detil/delete/{id}', [TransaksiController::class, 'detilDestroy'])->name('transaksiDetil.destroy');
Route::get('transaksi/edit/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit');
Route::post('transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
//ROUTE CASE 2
Route::get('/crawl-kurs', [KursController::class, 'crawl'])->name('crawl.data');
//ROUTE CASE 3
Route::get('/operator', [ScoreController::class, 'showOperator'])->name('operator');
Route::get('/scoreboard', [ScoreController::class, 'showScoreboard'])->name('scoreboard');
Route::post('/update-score', [ScoreController::class, 'update'])->name('update-score');
