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
    Route::get('/scan-item', 'scanItem')->name('scan-item');
    Route::get('/getdataqr', 'getdataqr')->name('getdataqr');
    Route::get('/getdataqr_sb', 'getdataqr_sb')->name('getdataqr_sb');
    Route::get('/getdataqr_defect', 'getdataqr_defect')->name('getdataqr_defect');
    Route::get('/getdataqr_reject', 'getdataqr_reject')->name('getdataqr_reject');
    Route::get('/getdataqr_gambar', 'getdataqr_gambar')->name('getdataqr_gambar');

    Route::get('/get-data', 'getData')->name('getData');
    Route::get('/get-data-penerimaan-kain', 'getDataPenerimaanKain')->name('getDataPenerimaanKain');
    Route::get('/get-data-fabric-inspection', 'getDataFabricInspection')->name('getDataFabricInspection');
    Route::get('/get-data-mutasi-rak', 'getDataMutasiRak')->name('getDataMutasiRak');
    Route::get('/get-data-pengeluaran-kain', 'getDataPengeluaranKain')->name('getDataPengeluaranKain');
    Route::get('/get-data-pemakaian-kain', 'getDataPemakaianKain')->name('getDataPemakaianKain');
    Route::get('/get-data-return-kain', 'getDataReturnKain')->name('getDataReturnKain');
});
