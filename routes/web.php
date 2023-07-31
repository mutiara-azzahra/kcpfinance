<?php

use App\Http\Middleware\Auth;

use App\Http\Controllers\JurnalController;
use App\Http\Controllers\PerkiraanController;
use App\Http\Controllers\PersediaanController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\ClosingAccountPerkiraan;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterLevelController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\NeracaSaldoController;
use App\Http\Controllers\LoginController;


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
    return view('login');
});

Route::get('/dashboard', function () {
    return view('welcome');
});

//ProvinsiController
Route::resource('provinsi', ProvinsiController::class);

//JurnalController
Route::get('/login', 'LoginController@formLogin')->name('login.form');
Route::post('/login', 'LoginController@actionLogin')->name('login.auth');
Route::get('/logout', 'LoginController@logout')->name('login.logout');

//JurnalController
Route::get('/jurnal/index', 'JurnalController@index')->name('jurnal.index');
Route::get('/jurnal/create', 'JurnalController@create')->name('jurnal.create');
Route::get('/jurnal/report', 'JurnalController@getJurnalHeader')->name('jurnal.report');

//BukuBesarController
Route::get('/buku-besar/index', 'BukuBesarController@index')->name('buku-besar.index');
Route::get('/buku-besar/report', 'BukuBesarController@getBukuBesarPerkiraan')->name('buku-besar.report');


//PerkiraanController
Route::get('/closing-account/index', 'ClosingAccountController@index')->name('closing-account.index');
Route::get('/closing-account/create', 'ClosingAccountController@create')->name('closing-account.create');
Route::get('/closing-account/edit', 'ClosingAccountController@edit')->name('closing-account.edit');
Route::get('/closing-account/destroy', 'ClosingAccountController@destroy')->name('closing-account.destroy');

//NeracaController
Route::get('/neraca/index', 'NeracaController@index')->name('neraca.index');
Route::get('/neraca/create', 'NeracaController@create')->name('neraca.create');
Route::get('/neraca/edit', 'NeracaController@edit')->name('neraca.edit');
Route::get('/neraca/destroy', 'NeracaController@destroy')->name('neraca.destroy');
Route::get('/neraca/report', 'NeracaController@getNeraca')->name('neraca.report');

//PerkiraanController
Route::get('/perkiraan/index', 'PerkiraanController@index')->name('perkiraan.index');
Route::get('/perkiraan/create', 'PerkiraanController@create')->name('perkiraan.create');
Route::get('/perkiraan/edit', 'PerkiraanController@edit')->name('perkiraan.edit');
Route::get('/perkiraan/destroy', 'PerkiraanController@destroy')->name('perkiraan.destroy');

//PersediaanController
Route::get('/persediaan/filter', 'persediaanController@filter')->name('persediaan.filter');
Route::get('/persediaan/process', 'persediaanController@process')->name('persediaan.process');
Route::get('/persediaan/view', 'persediaanController@getPersediaan')->name('persediaan.view');

//NeracaSaldoController
Route::get('/neraca-saldo/index', 'NeracaSaldoController@index')->name('neraca-saldo.index');
Route::get('/neraca-saldo/create', 'NeracaSaldoController@create')->name('neraca-saldo.create');
Route::get('/neraca-saldo/edit', 'NeracaSaldoController@edit')->name('neraca-saldo.edit');
Route::get('/neraca-saldo/destroy', 'NeracaSaldoController@destroy')->name('neraca-saldo.destroy');
Route::get('/neraca-saldo/report', 'NeracaSaldoController@getNeracaSaldo')->name('neraca-saldo.report');

//BarangController
Route::get('/barang/index', 'MasterBarangController@index')->name('barang.index');
Route::get('/barang/create', 'MasterBarangController@create')->name('barang.create');
Route::get('/barang/edit', 'MasterBarangController@edit')->name('barang.edit');
Route::get('/barang/destroy', 'MasterBarangController@destroy')->name('barang.destroy');
Route::get('/barang/detail/{id}', 'MasterBarangController@detail')->name('barang.detail');

//LevelController
Route::get('/level/index', 'MasterLevelController@index')->name('level.index');
Route::get('/level/edit/{id}', 'MasterLevelController@edit')->name('level.edit');
Route::get('/level/create', 'MasterLevelController@create')->name('level.create');
Route::post('/level/store', 'MasterLevelController@store')->name('level.store');
Route::post('/level/update/{id}', 'MasterLevelController@update')->name('level.update');
Route::delete('/level/destroy/{id}', 'MasterLevelController@destroy')->name('level.destroy');


//LevelController
Route::get('/kode-part/index', 'KodePartController@index')->name('kode-part.index');
Route::get('/kode-part/edit/{id}', 'KodePartController@edit')->name('kode-part.edit');
Route::get('/kode-part/create', 'KodePartController@create')->name('kode-part.create');
Route::post('/kode-part/store', 'KodePartController@store')->name('kode-part.store');
Route::post('/kode-part/update/{id}', 'KodePartController@update')->name('kode-part.update');
Route::delete('/kode-part/destroy/{id}', 'KodePartController@destroy')->name('kode-part.destroy');