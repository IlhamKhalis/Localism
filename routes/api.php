<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//PETUGAS
Route::post('/register', 'Petugas@register');
Route::post('/login', 'Petugas@login');
Route::post('/edit_petugas/{id}', 'Petugas@edit')->middleware('jwt.verify');
Route::get('/tampil_petugas ', 'Petugas@tampil')->middleware('jwt.verify');
Route::delete('/hapus_petugas/{id}', 'Petugas@delete')->middleware('jwt.verify');

//KATEGORI
Route::post('/register_kategori', 'KategoriController@store')->middleware('jwt.verify');
Route::post('/edit_kategori/{id}', 'KategoriController@update')->middleware('jwt.verify');
Route::get('/tampil_kategori', 'KategoriController@tampil');
Route::delete('/hapus_kategori/{id}', 'KategoriController@destroy')->middleware('jwt.verify');

//ARTIKEL
Route::post('/register_artikel', 'Artikel@store')->middleware('jwt.verify');
Route::post('/edit_artikel/{id}', 'Artikel@update')->middleware('jwt.verify');
Route::get('/tampil_artikel_brand', 'Artikel@tampil_brand');
Route::get('/tampil_artikel_kategori', 'Artikel@tampil_kategori');
Route::delete('/hapus_artikel/{id}', 'Artikel@destroy')->middleware('jwt.verify');

//BRAND
Route::post('/register_brand', 'BrandController@store')->middleware('jwt.verify');
Route::post('/edit_brand/{id}', 'BrandController@update')->middleware('jwt.verify');
Route::get('/tampil_brand', 'BrandController@tampil');
Route::delete('/hapus_brand/{id}', 'BrandController@destroy')->middleware('jwt.verify');