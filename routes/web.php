<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;

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
    return view('production-qr');
});

Route::controller(ScanController::class)->prefix("scan")->group(function () {
    Route::get('/', 'index')->name('scan');
    Route::get('/get-data', 'getData')->name('getData');
    Route::get('/get-data-penerimaan-kain', 'getDataPenerimaanKain')->name('getDataPenerimaanKain');
    Route::get('/get-data-fabric-inspection', 'getDataFabricInspection')->name('getDataFabricInspection');
    Route::get('/get-data-mutasi-rak', 'getDataMutasiRak')->name('getDataMutasiRak');
    Route::get('/get-data-pengeluaran-kain', 'getDataPengeluaranKain')->name('getDataPengeluaranKain');
    Route::get('/get-data-penerimaan-cutting', 'getDataPenerimaanCutting')->name('getDataPenerimaanCutting');
    Route::get('/get-data-pemakaian-kain', 'getDataPemakaianKain')->name('getDataPemakaianKain');
    Route::get('/get-data-return-kain', 'getDataReturnKain')->name('getDataReturnKain');
});
