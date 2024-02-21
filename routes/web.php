<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('guest')->group(function(){
	Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
	Route::post('/login',[AuthController::class, 'authenticate'])->name('login.process');
	Route::get('/register',[AuthController::class, 'register_index'])->name('register');
	Route::post('/register',[AuthController::class, 'register'])->name('register.process');

});


Route::middleware('auth')->group(function(){
    Route::get('/app', function () {
        return view('layouts.app');
    })->name('app');
	Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::name('buku.')->prefix('buku')->group(function () {
		Route::get('/', 'BukuController@index')->name('index');
		Route::get('/tables', 'BukuController@tables')->name('tables');
		Route::post('/', 'BukuController@store')->name('store');
		Route::put('/', 'BukuController@update')->name('update');
		Route::delete('/', 'BukuController@delete')->name('delete');
	});

    Route::name('kategori.')->prefix('kategori')->group(function () {
		Route::get('/', 'KategoriController@index')->name('index');
		Route::get('/tables', 'KategoriController@tables')->name('tables');
		Route::post('/', 'KategoriController@store')->name('store');
		Route::put('/', 'KategoriController@update')->name('update');
		Route::delete('/', 'KategoriController@delete')->name('delete');
	});

    Route::name('peminjaman.')->prefix('peminjaman')->group(function () {
		Route::get('/', 'PeminjamanController@index')->name('index');
		Route::get('/tables', 'PeminjamanController@tables')->name('tables');
		Route::post('/', 'PeminjamanController@store')->name('store');
		Route::put('/', 'PeminjamanController@update')->name('update');
		Route::delete('/', 'PeminjamanController@delete')->name('delete');
	});

    Route::name('ulasan.')->prefix('ulasan')->group(function () {
		Route::get('/', 'UlasanController@index')->name('index');
		Route::get('/tables', 'UlasanController@tables')->name('tables');
		Route::post('/', 'UlasanController@store')->name('store');
		Route::put('/', 'UlasanController@update')->name('update');
		Route::delete('/', 'UlasanController@delete')->name('delete');
	});

    Route::name('koleksi.')->prefix('koleksi')->group(function () {
		Route::get('/', 'KoleksiController@index')->name('index');
		Route::get('/tables', 'KoleksiController@tables')->name('tables');
		Route::post('/', 'KoleksiController@store')->name('store');
		Route::put('/', 'KoleksiController@update')->name('update');
		Route::delete('/', 'KoleksiController@delete')->name('delete');
	});

	Route::name('role-pengguna.')->prefix('role-pengguna')->group(function () {
		Route::get('/', 'RoleController@index')->name('index');
		Route::get('/permissions/{roleId}', 'RoleController@getRolePermissions')->name('getRolePermissions');
		Route::post('/permissions/{roleId}', 'RoleController@updatePerms')->name('updatePerms');
		Route::get('/tables', 'RoleController@tables')->name('tables');
		Route::post('/', 'RoleController@store')->name('store');
		Route::put('/', 'RoleController@update')->name('update');
		Route::delete('/', 'RoleController@destroy')->name('delete');
	});
});
